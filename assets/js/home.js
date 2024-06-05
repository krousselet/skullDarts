document.addEventListener('DOMContentLoaded', () => {
    let catchHomeString = 'v.e.n.e.z t.e.n.t.e.r l.e d.i.a.b.l.e';
    let segments = catchHomeString.split(' ');  // Split by spaces into separate segments
    let allArrays = segments.map(segment => segment.split('.'));  // Split each segment by dot into arrays
    let catchContainer = document.querySelector('.catch-container');

    function createAndAnimateElement(char, delay) {
        let span = document.createElement('span');
        span.textContent = char;
        span.style.opacity = "0";  // Set initial opacity to 0
        catchContainer.appendChild(span);
        setTimeout(() => {
            span.classList.add('animated');
        }, delay);
    }

    function createSpaceElement() {
        let space = document.createElement('span');
        space.innerHTML = '&nbsp;';  // Add a non-breaking space
        catchContainer.appendChild(space);
    }

    let delay = 0;
    allArrays.forEach((array, arrayIndex) => {
        array.forEach(char => {
            createAndAnimateElement(char, delay);
            delay += 50; // 500ms delay between each character
        });
        if (arrayIndex < allArrays.length - 1) {
            createSpaceElement();
            delay += 50;
        }
    });
});