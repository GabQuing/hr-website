const video = document.getElementById("video");
const cameraWrapper = document.querySelector(".cameraWrapper");

Promise.all([
  faceapi.nets.ssdMobilenetv1.loadFromUri("./models"),
  faceapi.nets.faceRecognitionNet.loadFromUri("./models"),
  faceapi.nets.faceLandmark68Net.loadFromUri("./models"),
])
  .then(startWebcam)
  .then(faceRecognition);

function startWebcam() {
  navigator.mediaDevices
    .getUserMedia({
      video: true,
      audio: false,
    })
    .then((stream) => {
      video.srcObject = stream;
    })
    .catch((error) => {
      console.error(error);
    });
}

async function getLabeledFaceDescriptions() {
  const response = await fetch('./api/employee-names');
  const employeeNames = await response.json();

  return Promise.all(
    employeeNames.map(async (label) => {
      const descriptions = [];
      for (let i = 1; i <= 2; i++) {
        const img = await faceapi.fetchImage(`./labels/${label}/${i}.png`);
        const detections = await faceapi
          .detectSingleFace(img)
          .withFaceLandmarks()
          .withFaceDescriptor();
        descriptions.push(detections.descriptor);
      }
      return new faceapi.LabeledFaceDescriptors(label, descriptions);
    })
  );
}

async function faceRecognition() {
  const labeledFaceDescriptors = await getLabeledFaceDescriptions();
  const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors);
  
  video.addEventListener("playing", () => {
    location.reload();
  });

  const canvas = faceapi.createCanvasFromMedia(video);
  cameraWrapper.append(canvas);

  const displaySize = { width: video.width, height: video.height };
  faceapi.matchDimensions(canvas, displaySize);

  const stopVideo = setInterval(async () => {
    const detections = await faceapi
      .detectAllFaces(video)
      .withFaceLandmarks()
      .withFaceDescriptors();

    const resizedDetections = faceapi.resizeResults(detections, displaySize);

    canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);

    const results = resizedDetections.map((d) => {
      return faceMatcher.findBestMatch(d.descriptor);
    });

    results.forEach((result, i) => {
      const box = resizedDetections[i].detection.box;
      const drawBox = new faceapi.draw.DrawBox(box, {
        label: result.toString(), // Display the label (employee name) and pseudo-confidence level
      });
      drawBox.draw(canvas);
      const label = result.label;
      const distance = result.distance;
      const pseudoConfidence = 1 - distance; // Calculate pseudo-confidence level
      const internalConfidenceLevel = (pseudoConfidence * 100).toFixed(2);
      $("#loginName").text(label);
      $("#logoutName").text(label);
      $('.timeInName').val(label);
      $('.timeOutName').val(label);
      $('#employee_id').text(label.replace(/_/gi, ' '));
      $('#confidence').text(internalConfidenceLevel + '%'); // Display the pseudo-confidence level in the DOM
      confidenceLevel = internalConfidenceLevel;
    });
  }, 100);
}
