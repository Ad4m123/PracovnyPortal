document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-stars label.star');
    const inputs = document.querySelectorAll('.rating-stars input[type="radio"]');

    stars.forEach((star, index) => {
        star.addEventListener('mouseover', function() {
            // Highlight stars up to current one
            for (let i = 0; i <= index; i++) {
                stars[i].style.color = '#ffc107';
            }
            // Remove highlight from stars after current one
            for (let i = index + 1; i < stars.length; i++) {
                stars[i].style.color = '#ddd';
            }
        });

        star.addEventListener('click', function() {
            // Check the corresponding radio button
            inputs[index].checked = true;
        });
    });

    // Reset colors when mouse leaves the rating area
    document.querySelector('.rating-stars').addEventListener('mouseleave', function() {
        const checkedInput = document.querySelector('.rating-stars input[type="radio"]:checked');
        if (checkedInput) {
            const checkedIndex = Array.from(inputs).indexOf(checkedInput);
            // Highlight stars up to checked one
            for (let i = 0; i <= checkedIndex; i++) {
                stars[i].style.color = '#ffc107';
            }
            // Remove highlight from stars after checked one
            for (let i = checkedIndex + 1; i < stars.length; i++) {
                stars[i].style.color = '#ddd';
            }
        } else {
            // No star selected, reset all
            stars.forEach(star => star.style.color = '#ddd');
        }
    });
});