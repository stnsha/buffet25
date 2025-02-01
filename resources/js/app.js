import 'flowbite';

document.addEventListener('click', function (e) {
    if (e.target.closest('.add-category')) {
        let container = document.getElementById('categories-container');
        let lastItem = container.lastElementChild;
        let newField = lastItem.cloneNode(true);

        // Clear input values
        newField.querySelectorAll('input').forEach(input => input.value = '');

        container.appendChild(newField);
    }

    if (e.target.closest('.remove-category')) {
        let items = document.querySelectorAll('.category-item');
        if (items.length > 1) {
            e.target.closest('.category-item').remove();
        }
    }
});
