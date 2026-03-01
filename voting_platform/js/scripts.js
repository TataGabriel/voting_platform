document.addEventListener('DOMContentLoaded', () => {
    const minusBtn = document.getElementById('minus');
    const plusBtn = document.getElementById('plus');
    const voteInput = document.getElementById('voteCount');
    const votesField = document.getElementById('votesField');

    if (minusBtn && plusBtn && voteInput) {
        minusBtn.addEventListener('click', () => {
            let v = parseInt(voteInput.value, 10);
            if (v > 1) {
                voteInput.value = v - 1;
                if (votesField) votesField.value = voteInput.value;
            }
        });
        plusBtn.addEventListener('click', () => {
            let v = parseInt(voteInput.value, 10);
            voteInput.value = v + 1;
            if (votesField) votesField.value = voteInput.value;
        });
    }

    // payment page: update total amount when votes changed (should not be possible here)
    const totalAmountSpan = document.getElementById('totalAmount');
    if (totalAmountSpan) {
        // amount is server calculated
    }
});