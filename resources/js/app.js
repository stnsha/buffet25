import 'flowbite';

function calculateSubtotal() {
    let subtotal = 0;

    document.querySelectorAll('select[id$="_quantity"]').forEach(select => {
        const priceId = select.id.split('_')[0]; // Extract price ID
        const priceField = document.getElementById(`${priceId}_price`);

        if (!priceField) {
            console.error(`Price field not found for ID: ${priceId}_price`);
            return; // Skip this iteration if priceField is null
        }

        const quantity = parseInt(select.value) || 0;
        const basePrice = parseFloat(priceField.getAttribute('data-base-price')) || 0;

        const totalPrice = quantity * basePrice;
        priceField.value = totalPrice.toFixed(2); // Update price input field

        subtotal += totalPrice;
    });

    // Baby chair calculation (if applicable)
    const babyChairSelect = document.getElementById('baby_chair');
    if (babyChairSelect) {
        const babyChairQuantity = parseInt(babyChairSelect.value) || 0;
        const babyChairPrice = 0; // Modify if necessary
        subtotal += babyChairQuantity * babyChairPrice;
    }

    // Update subtotal
    const subtotalField = document.getElementById('subtotal');
    if (subtotalField) {
        subtotalField.value = subtotal.toFixed(2);
    } else {
        console.error('Subtotal field not found');
    }
}

// Attach event listeners
document.querySelectorAll('select[id$="_quantity"], #baby_chair').forEach(select => {
    select.addEventListener('change', calculateSubtotal);
});

// Initial calculation
calculateSubtotal();

//reservations table

if (document.getElementById("reservations-table") && typeof simpleDatatables.DataTable !== 'undefined') {
    const dataTable = new simpleDatatables.DataTable("#reservations-table", {
        searchable: false,
        perPageSelect: false
    });
}
