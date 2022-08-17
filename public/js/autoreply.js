
$('#type').on('change', () => {
    const type = $('#type').val();
    $.ajax({
        url: `/autoreply/${type}`,
        type: 'GET',
        dataType: 'html',
        success: (result) => {

            $('.ajaxplace').html(result)
        },
        error: (error) => {
            console.log(error);
        }
    })
})


function viewReply(id) {
    $.ajax({
        url: `/autoreply/show-reply/${id}`,
        type: 'GET',
        dataType: 'html',
        success: (result) => {

            $('.showReply').html(result);
            $('#modalView').modal('show')
        },
        error: (error) => {
            console.log(error);
        }
    })
    // 
}

