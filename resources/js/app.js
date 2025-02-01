import 'flowbite';

//add new category when creating new price
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

//calculate subtotal of price when quantity selected
function calculateSubtotal() {
    let subtotal = 0;

    // Loop through all quantity selects and calculate price for each
    document.querySelectorAll('select[id$="_quantity"]').forEach(select => {
        const priceId = select.id.split('_')[0];  // Get the price ID from the select ID
        const quantity = parseInt(select.value);
        const price = parseFloat(document.getElementById(`${priceId}_price`).value);

        subtotal += quantity * price;
    });

    // Check if baby chair quantity is selected and add its value
    const babyChairQuantity = parseInt(document.getElementById('baby_chair').value);
    const babyChairPrice = 0; // You can adjust the price if necessary, here it's FOC (free)
    
    subtotal += babyChairQuantity * babyChairPrice;

    // Update the subtotal field
    document.getElementById('subtotal').value = subtotal.toFixed(2);
}

// Add event listeners to recalculate subtotal when quantity changes
document.querySelectorAll('select[id$="_quantity"], #baby_chair').forEach(select => {
    select.addEventListener('change', calculateSubtotal);
});

// Initial calculation
calculateSubtotal();