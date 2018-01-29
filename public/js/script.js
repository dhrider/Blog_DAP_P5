$(document).ready(function () {
   $('#closeContactMessage').on('click',function () {
       $('#menuHome').get(0).click();
   });

    $('#closeNewPostMessage').on('click',function () {
        $('#menuManagePost').get(0).click();
    });
});
