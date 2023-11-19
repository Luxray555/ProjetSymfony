function halfStar(rating) {
    const fifthStar = document.querySelector('.rating .star:nth-child(5)');

    if (rating !== Math.floor(rating)) {
        const decimalPart = rating - Math.floor(rating);
        const widthPercentage = decimalPart * 100 + '%';
        fifthStar.style.setProperty('--width', widthPercentage);
    }
}