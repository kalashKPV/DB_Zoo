$(document).on('click', '#checkbox', function () {
    let checkboxStatus = $(this).prop("checked");
    let is_admin=0;
    console.log(checkboxStatus);
    if(checkboxStatus == true){
        is_admin=1;
    } else {
        is_admin=0;
    }
    console.log(is_admin);
    $("#is_admin").val(is_admin);
})
