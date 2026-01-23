// Face Verification for DTR
let currentAction = '';
let faceVideoStream = null;
let faceDetectionLoop = null;
let userFaceDescriptor = null;
let verifyModelsLoaded = false;

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

// Load Face-API models for verification
async function loadVerifyModels() {
    if (verifyModelsLoaded) return;
    
    try {
        await waitForFaceAPI();
        
        const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model';
        await Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
            faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
            faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
        ]);
        verifyModelsLoaded = true;
        console.log('Verification Face-API models loaded successfully');
    } catch (error) {
        console.error('Error loading Verification Face-API models:', error);
    }
}

// Set user's registered face descriptor (called from dashboard)
function setUserFaceDescriptor(descriptor) {
    userFaceDescriptor = descriptor;
}

async function openFaceVerificationModal(action) {
    currentAction = action;
    const modal = document.getElementById('faceVerificationModal');
    const video = document.getElementById('verifyFaceVideo');
    const statusText = document.getElementById('verifyFaceStatus');
    const verifyBtn = document.getElementById('verifyFaceBtn');

    modal.classList.remove('hidden');
    verifyBtn.disabled = true;

    // Check if user has registered face
    if (!userFaceDescriptor) {
        statusText.innerHTML = '<span class="text-red-600">⚠ No face registered. Please register your face in your profile first.</span>';
        return;
    }

    // Load models if not loaded
    if (!verifyModelsLoaded) {
        statusText.innerHTML = 'Loading face recognition models...';
        await loadVerifyModels();
    }

    // Start camera
    try {
        statusText.innerHTML = 'Starting camera...';
        faceVideoStream = await navigator.mediaDevices.getUserMedia({ 
            video: { 
                facingMode: 'user',
                width: { ideal: 640 },
                height: { ideal: 480 }
            } 
        });
        video.srcObject = faceVideoStream;

        video.onloadedmetadata = () => {
            video.play();
            startFaceVerification();
        };
    } catch (error) {
        console.error('Camera error:', error);
        statusText.innerHTML = '<span class="text-red-600">Camera access denied. Please enable camera permission.</span>';
    }
}

async function startFaceVerification() {
    const video = document.getElementById('verifyFaceVideo');
    const statusText = document.getElementById('verifyFaceStatus');
    const verifyBtn = document.getElementById('verifyFaceBtn');
    const overlay = document.getElementById('verifyFaceOverlay');

    // Ensure models are loaded
    if (!verifyModelsLoaded) {
        statusText.innerHTML = 'Loading models...';
        await loadVerifyModels();
    }

    statusText.innerHTML = 'Position your face in the camera...';

    faceDetectionLoop = setInterval(async () => {
        try {
            const detection = await faceapi
                .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.4 }))
                .withFaceLandmarks()
                .withFaceDescriptor();

            overlay.innerHTML = '';

            if (detection && detection.detection && detection.detection.box) {
                // Draw circular face overlay (Face ID style)
                const box = detection.detection.box;
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.style.position = 'absolute';
                canvas.style.top = '0';
                canvas.style.left = '0';
                canvas.style.width = '100%';
                canvas.style.height = '100%';
                
                const ctx = canvas.getContext('2d');
                
                // Calculate center and radius for circular overlay
                const centerX = (box.x + box.width / 2) * (canvas.width / video.videoWidth);
                const centerY = (box.y + box.height / 2) * (canvas.height / video.videoHeight);
                const radius = Math.max(box.width, box.height) / 2 * (canvas.width / video.videoWidth) * 0.8;
                
                // Compare with registered face
                const distance = faceapi.euclideanDistance(detection.descriptor, userFaceDescriptor);
                const similarity = Math.max(0, (1 - distance)) * 100;
                
                // Color code based on match quality
                let strokeColor, glowColor;
                if (similarity >= 60) {
                    strokeColor = '#10b981'; // Green - good match
                    glowColor = 'rgba(16, 185, 129, 0.3)';
                    statusText.innerHTML = `<span class="text-green-600">✓ Face matched (${similarity.toFixed(1)}%)! Click Verify to proceed.</span>`;
                    verifyBtn.disabled = false;
                } else if (similarity >= 40) {
                    strokeColor = '#f59e0b'; // Orange - moderate match
                    glowColor = 'rgba(245, 158, 11, 0.3)';
                    statusText.innerHTML = `<span class="text-yellow-600">⚠ Moderate match (${similarity.toFixed(1)}%). Adjust lighting or position.</span>`;
                    verifyBtn.disabled = true;
                } else {
                    strokeColor = '#ef4444'; // Red - poor match
                    glowColor = 'rgba(239, 68, 68, 0.3)';
                    statusText.innerHTML = `<span class="text-red-600">✗ Face not recognized (${similarity.toFixed(1)}%). Please try again.</span>`;
                    verifyBtn.disabled = true;
                }
                
                // Draw circular scanning animation (Face ID style)
                ctx.strokeStyle = strokeColor;
                ctx.lineWidth = 4;
                ctx.shadowBlur = 20;
                ctx.shadowColor = glowColor;
                
                // Draw main circle
                ctx.beginPath();
                ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
                ctx.stroke();
                
                // Draw animated scanning arc
                const scanAngle = (Date.now() / 1000) % (2 * Math.PI);
                ctx.beginPath();
                ctx.arc(centerX, centerY, radius + 10, scanAngle, scanAngle + Math.PI / 3);
                ctx.lineWidth = 3;
                ctx.stroke();
                
                // Draw corner marks (Face ID style)
                const markLength = 30;
                const markOffset = radius * 0.7;
                ctx.lineWidth = 3;
                ctx.lineCap = 'round';
                
                // Top-left
                ctx.beginPath();
                ctx.moveTo(centerX - markOffset, centerY - markOffset - markLength);
                ctx.lineTo(centerX - markOffset, centerY - markOffset);
                ctx.lineTo(centerX - markOffset + markLength, centerY - markOffset);
                ctx.stroke();
                
                // Top-right
                ctx.beginPath();
                ctx.moveTo(centerX + markOffset, centerY - markOffset - markLength);
                ctx.lineTo(centerX + markOffset, centerY - markOffset);
                ctx.lineTo(centerX + markOffset - markLength, centerY - markOffset);
                ctx.stroke();
                
                // Bottom-left
                ctx.beginPath();
                ctx.moveTo(centerX - markOffset, centerY + markOffset + markLength);
                ctx.lineTo(centerX - markOffset, centerY + markOffset);
                ctx.lineTo(centerX - markOffset + markLength, centerY + markOffset);
                ctx.stroke();
                
                // Bottom-right
                ctx.beginPath();
                ctx.moveTo(centerX + markOffset, centerY + markOffset + markLength);
                ctx.lineTo(centerX + markOffset, centerY + markOffset);
                ctx.lineTo(centerX + markOffset - markLength, centerY + markOffset);
                ctx.stroke();
                
                overlay.appendChild(canvas);
            } else {
                statusText.innerHTML = 'No face detected. Please position your face clearly.';
                verifyBtn.disabled = true;
            }
        } catch (error) {
            console.error('Face detection error:', error);
            statusText.innerHTML = 'Detection error. Retrying...';
        }
    }, 500);
}

// Initialize models when page loads
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadVerifyModels);
} else {
    loadVerifyModels();
}

async function verifyAndSubmit() {
    const video = document.getElementById('verifyFaceVideo');
    const statusText = document.getElementById('verifyFaceStatus');
    const verifyBtn = document.getElementById('verifyFaceBtn');

    verifyBtn.disabled = true;
    statusText.innerHTML = 'Verifying face...';

    try {
        const detection = await faceapi
            .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceDescriptor();

        if (detection) {
            const distance = faceapi.euclideanDistance(detection.descriptor, userFaceDescriptor);
            const similarity = Math.max(0, (1 - distance)) * 100;

            if (similarity >= 60) {
                // Capture photo
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                const photoBase64 = canvas.toDataURL('image/jpeg', 0.8);

                // Set form data
                if (currentAction === 'timein') {
                    document.getElementById('timeInFacePhoto').value = photoBase64;
                    document.getElementById('timeInFaceConfidence').value = similarity.toFixed(2);
                    closeFaceVerificationModal();
                    document.getElementById('timeInForm').submit();
                } else {
                    document.getElementById('timeOutFacePhoto').value = photoBase64;
                    document.getElementById('timeOutFaceConfidence').value = similarity.toFixed(2);
                    closeFaceVerificationModal();
                    document.getElementById('timeOutForm').submit();
                }
            } else {
                statusText.innerHTML = '<span class="text-red-600">Face verification failed. Please try again.</span>';
                verifyBtn.disabled = false;
            }
        }
    } catch (error) {
        console.error('Verification error:', error);
        statusText.innerHTML = '<span class="text-red-600">Error during verification. Please try again.</span>';
        verifyBtn.disabled = false;
    }
}

function closeFaceVerificationModal() {
    const modal = document.getElementById('faceVerificationModal');
    const video = document.getElementById('verifyFaceVideo');
    const overlay = document.getElementById('verifyFaceOverlay');

    if (faceVideoStream) {
        faceVideoStream.getTracks().forEach(track => track.stop());
        faceVideoStream = null;
    }

    if (faceDetectionLoop) {
        clearInterval(faceDetectionLoop);
        faceDetectionLoop = null;
    }

    overlay.innerHTML = '';
    modal.classList.add('hidden');
    video.srcObject = null;
}
