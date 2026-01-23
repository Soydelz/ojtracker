// Profile Face Registration (for users without registered face)
let profileFaceStream = null;
let profileFaceLoop = null;
let profileModelsLoaded = false;

// Wait for faceapi to be available
function waitForFaceAPI() {
    return new Promise((resolve) => {
        if (typeof faceapi !== 'undefined') {
            resolve();
        } else {
            const checkInterval = setInterval(() => {
                if (typeof faceapi !== 'undefined') {
                    clearInterval(checkInterval);
                    resolve();
                }
            }, 100);
        }
    });
}

// Load Face-API models
async function loadProfileFaceModels() {
    if (profileModelsLoaded) return;
    
    try {
        await waitForFaceAPI(); // Wait for library to load
        
        const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model';
        await Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
            faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
            faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
        ]);
        profileModelsLoaded = true;
        console.log('Profile Face-API models loaded successfully');
    } catch (error) {
        console.error('Error loading Profile Face-API models:', error);
    }
}

// Initialize models on page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadProfileFaceModels);
} else {
    loadProfileFaceModels();
}

async function openProfileFaceCapture() {
    const modal = document.createElement('div');
    modal.id = 'profileFaceModal';
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
    modal.innerHTML = `
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Register Your Face</h2>
                    <button onclick="closeProfileFaceCapture()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="relative bg-gray-900 rounded-lg overflow-hidden mb-4" style="aspect-ratio: 4/3;">
                    <video id="profileFaceVideo" autoplay muted playsinline class="w-full h-full object-cover"></video>
                    <div id="profileFaceOverlay" class="absolute inset-0 pointer-events-none"></div>
                    <div class="absolute top-4 left-4 right-4">
                        <div class="bg-white bg-opacity-90 rounded-lg px-4 py-2 text-sm font-medium text-center">
                            <span id="profileFaceStatus">Initializing camera...</span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                    <p class="text-sm text-blue-800">
                        <strong>Required for DTR Attendance:</strong><br>
                        • Look directly at the camera<br>
                        • Ensure good lighting<br>
                        • Remove sunglasses/mask
                    </p>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeProfileFaceCapture()" 
                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="button" id="profileCaptureBtn" onclick="captureProfileFace()" disabled
                            class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Capture Face
                    </button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);

    const video = document.getElementById('profileFaceVideo');
    const statusText = document.getElementById('profileFaceStatus');
    const captureBtn = document.getElementById('profileCaptureBtn');

    // Wait for models to load
    if (!profileModelsLoaded) {
        statusText.textContent = 'Loading face detection models...';
        await loadProfileFaceModels();
    }

    try {
        statusText.textContent = 'Starting camera...';
        profileFaceStream = await navigator.mediaDevices.getUserMedia({ 
            video: { 
                facingMode: 'user',
                width: { ideal: 640 },
                height: { ideal: 480 }
            } 
        });
        video.srcObject = profileFaceStream;

        video.onloadedmetadata = () => {
            video.play();
            startProfileFaceDetection();
        };
    } catch (error) {
        console.error('Camera error:', error);
        statusText.textContent = 'Camera access denied. Please enable camera permission.';
    }
}

function startProfileFaceDetection() {
    const video = document.getElementById('profileFaceVideo');
    const statusText = document.getElementById('profileFaceStatus');
    const captureBtn = document.getElementById('profileCaptureBtn');
    const overlay = document.getElementById('profileFaceOverlay');

    statusText.textContent = 'Position your face in the camera...';

    profileFaceLoop = setInterval(async () => {
        try {
            const detection = await faceapi.detectSingleFace(
                video, 
                new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.4 })
            );

            overlay.innerHTML = '';

            if (detection) {
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
            statusText.style.color = '#10b981';
            captureBtn.disabled = false;
        } else {
            statusText.textContent = 'No face detected. Please position your face clearly.';
            statusText.style.color = '#6b7280';
            captureBtn.disabled = true;
        }
        } catch (error) {
            console.error('Face detection error:', error);
            statusText.textContent = 'Detection error. Retrying...';
        }
    }, 500);
}

async function captureProfileFace() {
    const video = document.getElementById('profileFaceVideo');
    const statusText = document.getElementById('profileFaceStatus');
    const captureBtn = document.getElementById('profileCaptureBtn');

    captureBtn.disabled = true;
    statusText.textContent = 'Processing face data...';

    try {
        const detection = await faceapi
            .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceDescriptor();

        if (detection) {
            const descriptor = Array.from(detection.descriptor);
            document.getElementById('profile_face_descriptor').value = JSON.stringify(descriptor);
            
            const statusDiv = document.getElementById('face_registration_status');
            if (statusDiv) {
                statusDiv.classList.remove('hidden');
            }
            
            statusText.textContent = 'Face captured successfully!';
            
            setTimeout(() => {
                closeProfileFaceCapture();
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

function closeProfileFaceCapture() {
    const modal = document.getElementById('profileFaceModal');
    
    if (profileFaceStream) {
        profileFaceStream.getTracks().forEach(track => track.stop());
        profileFaceStream = null;
    }

    if (profileFaceLoop) {
        clearInterval(profileFaceLoop);
        profileFaceLoop = null;
    }

    if (modal) {
        modal.remove();
    }
}
