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

    // Update subtotal
    const subtotalField = document.getElementById('subtotal');
    if (subtotalField) {
        subtotalField.value = subtotal.toFixed(2);
    } else {
        console.error('Subtotal field not found');
    }
}

// Attach event listeners
document.querySelectorAll('select[id$="_quantity"]').forEach(select => {
    select.addEventListener('change', calculateSubtotal);
});

// Initial calculation
calculateSubtotal();

//reservations table

// if (document.getElementById("reservations-table") && typeof simpleDatatables.DataTable !== 'undefined') {
//     const dataTable = new simpleDatatables.DataTable("#reservations-table", {
//         searchable: true,
//         perPageSelect: true
//     });
// }


document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("categories-container");

    // Add new category
    container.addEventListener("click", function (event) {
        if (event.target.closest(".add-category")) {
            const newItem = container.firstElementChild.cloneNode(true);

            // Clear input values
            newItem.querySelectorAll("input").forEach(input => input.value = "");

            container.appendChild(newItem);
        }

        // Remove category
        if (event.target.closest(".remove-category")) {
            if (container.children.length > 1) {
                event.target.closest(".category-item").remove();
            }
        }
    });
});

