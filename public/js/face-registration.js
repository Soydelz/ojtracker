let faceModelsLoaded = false;
let videoStream = null;
let faceDetectionInterval = null;

// Load Face-API models
async function loadFaceAPIModels() {
    try {
        const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model';
        await Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
            faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
            faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
        ]);
        faceModelsLoaded = true;
        console.log('Face-API models loaded successfully');
    } catch (error) {
        console.error('Error loading Face-API models:', error);
    }
}

// Initialize models on page load
window.addEventListener('load', () => {
    loadFaceAPIModels();
});

// Open face capture modal
async function captureFaceRegistration() {
    const modal = document.getElementById('faceCaptureModal');
    const video = document.getElementById('faceVideo');
    const statusText = document.getElementById('faceStatusText');
    const captureBtn = document.getElementById('captureFaceBtn');

    modal.classList.remove('hidden');
    captureBtn.disabled = true;

    // Check if models are loaded
    if (!faceModelsLoaded) {
        statusText.textContent = 'Loading face detection models...';
        await loadFaceAPIModels();
    }

    // Start camera
    try {
        statusText.textContent = 'Starting camera...';
        videoStream = await navigator.mediaDevices.getUserMedia({ 
            video: { 
                facingMode: 'user',
                width: { ideal: 640 },
                height: { ideal: 480 }
            } 
        });
        video.srcObject = videoStream;

        // Wait for video to be ready
        video.onloadedmetadata = () => {
            video.play();
            startFaceDetection();
        };
    } catch (error) {
        console.error('Camera error:', error);
        statusText.textContent = 'Camera access denied. Please enable camera permission.';
    }
}

// Start continuous face detection
function startFaceDetection() {
    const video = document.getElementById('faceVideo');
    const statusText = document.getElementById('faceStatusText');
    const captureBtn = document.getElementById('captureFaceBtn');
    const overlay = document.getElementById('faceDetectionOverlay');

    statusText.textContent = 'Position your face in the camera...';

    faceDetectionInterval = setInterval(async () => {
        const detection = await faceapi.detectSingleFace(
            video, 
            new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.5 })
        );

        // Clear overlay
        overlay.innerHTML = '';

        if (detection) {
            // Draw face box
            const box = detection.box;
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.style.position = 'absolute';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.width = '100%';
            canvas.style.height = '100%';
            
            const ctx = canvas.getContext('2d');
            ctx.strokeStyle = '#10b981';
            ctx.lineWidth = 3;
            ctx.strokeRect(
                box.x * (canvas.width / video.videoWidth),
                box.y * (canvas.height / video.videoHeight),
                box.width * (canvas.width / video.videoWidth),
                box.height * (canvas.height / video.videoHeight)
            );
            
            overlay.appendChild(canvas);

            statusText.textContent = 'Face detected! Click Capture when ready.';
            captureBtn.disabled = false;
        } else {
            statusText.textContent = 'No face detected. Please position your face clearly.';
            captureBtn.disabled = true;
        }
    }, 500);
}

// Capture face and extract descriptor
async function captureFaceForRegistration() {
    const video = document.getElementById('faceVideo');
    const statusText = document.getElementById('faceStatusText');
    const captureBtn = document.getElementById('captureFaceBtn');

    captureBtn.disabled = true;
    statusText.textContent = 'Processing face data...';

    try {
        // Detect face with landmarks and descriptor
        const detection = await faceapi
            .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceDescriptor();

        if (detection) {
            // Get the 128D face descriptor
            const descriptor = Array.from(detection.descriptor);
            
            // Store in hidden input
            document.getElementById('register_face_descriptor').value = JSON.stringify(descriptor);
            
            // Update status badge in registration form
            const badge = document.getElementById('face_status_badge');
            badge.classList.remove('hidden');
            badge.textContent = '✓ Face Captured';
            
            statusText.textContent = 'Face captured successfully!';
            
            // Close modal after 1 second
            setTimeout(() => {
                closeFaceCapture();
            }, 1000);
        } else {
            statusText.textContent = 'Could not detect face. Please try again.';
            captureBtn.disabled = false;
        }
    } catch (error) {
        console.error('Face capture error:', error);
        statusText.textContent = 'Error capturing face. Please try again.';
        captureBtn.disabled = false;
    }
}

// Close face capture modal
function closeFaceCapture() {
    const modal = document.getElementById('faceCaptureModal');
    const video = document.getElementById('faceVideo');
    const overlay = document.getElementById('faceDetectionOverlay');

    // Stop video stream
    if (videoStream) {
        videoStream.getTracks().forEach(track => track.stop());
        videoStream = null;
    }

    // Clear detection interval
    if (faceDetectionInterval) {
        clearInterval(faceDetectionInterval);
        faceDetectionInterval = null;
    }

    // Clear overlay
    overlay.innerHTML = '';

    // Hide modal
    modal.classList.add('hidden');
    video.srcObject = null;
}

// Validate face registration on form submit
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.querySelector('form[action*="register"]');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const faceDescriptor = document.getElementById('register_face_descriptor');
            if (!faceDescriptor || !faceDescriptor.value) {
                e.preventDefault();
                alert('Please capture your face before registering. Face recognition is required for DTR Time In/Out attendance.');
                
                // Highlight the face registration section
                const faceSection = document.querySelector('.bg-gradient-to-br.from-indigo-50');
                if (faceSection) {
                    faceSection.classList.add('ring-2', 'ring-red-500', 'ring-offset-2');
                    setTimeout(() => {
                        faceSection.classList.remove('ring-2', 'ring-red-500', 'ring-offset-2');
                    }, 3000);
                }
                
                return false;
            }
        });
    }
});
