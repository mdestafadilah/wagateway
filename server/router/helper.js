
function formatReceipt(receipt) {
    try {
        if (receipt.endsWith('@g.us')) {
            return receipt
        }
        let formatted = receipt.replace(/\D/g, '');

        if (formatted.startsWith('0')) {
            formatted = '62' + formatted.substr(1);
        }

        if (!formatted.endsWith('@c.us')) {
            formatted += '@c.us';
        }

        return formatted;
    } catch (error) {
        console.log(error)
    }

    // }
}
async function asyncForEach(array, callback) {
    for (let index = 0; index < array.length; index++) {
        await callback(array[index], index, array);
    }
}

module.exports = {
    formatReceipt,
    asyncForEach
}