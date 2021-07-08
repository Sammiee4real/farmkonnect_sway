 <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Are you sure you want to logout?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="./logout">Logout</a>
        </div>
      </div>
    </div>
  </div>


<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/60e6b868649e0a0a5ccb230b/1fa2k0o5l';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->


  <!-- Bootstrap core JavaScript-->
  <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<!--//Metis Menu -->




  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>



 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" type="text/javascript"></script>

 <!-- <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
<script type="text/javascript">
      $(document).ready(function () {
      var countttt = $("#sms_content").val();
      $('#count').text(countttt.length);
      });


    function deleteRowwIncome(position){
        $("#pos"+position).remove();
        var currcount = $('#counterr').val();
        var newccount = currcount - 1;
        console.log(newccount);
      
          /////reset to disabled incase there is cancellation
              if(newccount == 0){
                // document.getElementById("cmd_add_entries").style.visibility = 'none';
                 document.getElementById("cmd_entries").disabled = true;
              }

        document.getElementById("counterr").value = newccount;
        document.getElementById("counterr2").textContent = newccount;
    }


    function deleteRowwExpense(position){
        $("#pos"+position).remove();
        var currcount = $('#counterr').val();
        var newccount = currcount - 1;
        console.log(newccount);
      
          /////reset to disabled incase there is cancellation
              if(newccount == 0){
                // document.getElementById("cmd_add_entries").style.visibility = 'none';
              document.getElementById("cmd_entries").disabled = true;
              }

        document.getElementById("counterr").value = newccount;
        document.getElementById("counterr2").textContent = newccount;
    }



    document.getElementById("cmd_entries").disabled = true;
    // document.getElementById("cmd_entries").disabled = true;
    // document.getElementById("cmd_add_entries").style.visibility = 'none';



</script>

<script type="text/javascript">
     
      $(document).ready(function() {
         
          // $('#dataTableServer').DataTable( {
         
       var all_members = $('#dataTableServer').DataTable({
          "scrollX": true,
          "processing": true,
          "serverSide": true,
          "ajax": "server_tables/all_members.php",
          // 'pagingType': 'numbers'
            "order": [[ 2, "asc" ]],
            "columnDefs": [
            { "render": all_members_action,
            "data": null,         
            "targets": [0], "width": "9%", "targets": 0 },
            ]
          } );

       var all_home_cell = $('#home_cell_table').DataTable({
          "scrollX": true,
          "processing": true,
          "serverSide": true,
          "ajax": "server_tables/all_home_cells.php",
          // 'pagingType': 'numbers'
            // "order": [[ 2, "asc" ]],
            // "columnDefs": [
            // { "render": all_home_cells_action,
            // "data": null,         
            // "targets": [0], "width": "9%", "targets": 0 },
            // ]
          } );
      
          function all_members_action(data, type, full) {
          return '<a href="./edit_member.php?id='+full[0]+'" class="btn btn-sm btn-primary">Edit</a>';
          }

      } );

</script>

  <script type="text/javascript">
    $(document).ready(function () {

         // toastr.info('Page Loaded!');
         $('.js-example-basic-single').select2();
         $('.js-example-basic-single2').select2();
         // $('.js-example-basic-singleyy').select2();
         $('.js-example-basic-multiple').select2();
         $('.js-example-basic-multiple2').select2();
         $('.js-example-basic-multiple3').select2();
         $('.js-example-basic-multiple4').select2();
         $('#marital_status_married').hide();
         $('#cmd_sms_blackist').hide();
         $('#cmd_sms_blackist_undo').hide();
         $('#display_ebook_price').hide();
         $('#display_hardcopy_book_price').hide();


         $(".js-example-basic-multiple_with_tags").select2({
          tags: true,
          tokenSeparators: [',', ' ']
         })
   
        // js-example-basic-multiple
        $('.logintest').click(function (e) {
              e.preventDefault();
              toastr.error("Testing lllllll", "Caution!");
        });

    

   ///adding users
  $('#cmd_add_user').click(function (e) {
          e.preventDefault();
         var first_name =  $('#first_name').val();
         var last_name =  $('#last_name').val();
         var email =  $('#email').val();
         var role =  $('#role').val();
         var phone =  $('#phone').val();
         var password =  $('#password').val();
      
                $.ajax({
                url:"ajax/add_users.php",
                method: "POST",
                data:$('#add_user_form').serialize(),
                  beforeSend: function(){
                  $(this).html('Please wait...');
                },
                success:function(data){
                  if(data == 200){
                     toastr.success("User was successfully created...", "Success!");
                     setTimeout( function(){ window.location.href = "all_users.php"; }, 3000);
                  }
                  else{
                      toastr.error(data, "Caution!");
                  }
                }
                });
                    
    });




   ///update profile
  $('#cmd_update_profile').click(function (e) {
          e.preventDefault();
                $.ajax({
                url:"ajax/update_profile.php",
                method: "POST",
                data:$('#update_profile_form').serialize(),
                  beforeSend: function(){
                  $(this).html('Please wait...');
                },
                success:function(data){
                  if(data == 200){
                     toastr.success("Your Profile was successfully updated...", "Nice Work!");
                     setTimeout( function(){ window.location.href = "home"; }, 3000);
                  }
                  else{
                      toastr.error(data, "Caution!");
                  }
                }
                });
                    
    });


  //reset password
  $('#cmd_password_reset').click(function (e) {
          e.preventDefault();
                $.ajax({
                url:"ajax/password_reset.php",
                method: "POST",
                data:$('#reset_password_form').serialize(),
                  beforeSend: function(){
                  $("#cmd_password_reset").attr('disabled', true);
                  $("#cmd_password_reset").text('Resetting password...');
                },
                success:function(data){
                  if(data == 200){
                     toastr.success("Password reset link has been sent to your email inbox... Check spam too..", "Nice Work!");
                     setTimeout( function(){ window.location.href = "home"; }, 3000);
                  }
                  else{
                      toastr.error(data, "Caution!");
                  }

                    $('#cmd_password_reset').attr('disabled', false);
                    $('#cmd_password_reset').text('Reset Password');
                }
                });
                    
    });

    //change password
  $('#cmd_change_password').click(function (e) {
          e.preventDefault();
                $.ajax({
                url:"ajax/change_password.php",
                method: "POST",
                data:$('#change_password_form').serialize(),
                  beforeSend: function(){
                  $("#cmd_change_password").attr('disabled', true);
                  $("#cmd_change_password").text('Updating password...');
                },
                success:function(data){
                  if(data == 200){
                     toastr.success("Your password was successfully updated...", "Nice Work!");
                     setTimeout( function(){ window.location.href = "index"; }, 3000);
                  }
                  else{
                      toastr.error(data, "Caution!");
                  }

                    $('#cmd_change_password').attr('disabled', false);
                    $('#cmd_change_password').text('Change Password');
                }
                });
                    
    });




  $('#cmd_signup').click(function (e) {
          e.preventDefault();
        
     $.ajax({
      url:"ajax/signup.php",
      method: "POST",
      data:$('#signup_form').serialize(),
      beforeSend: function(){
        //$(this).html('loading...');
        $("#cmd_signup").attr('disabled', true);
        $("#cmd_signup").text('signing up...');
      },
      success:function(data){
        //alert(data);
               if(data == 200){
                 toastr.success("Your registration was successful...", "Success!");
                 setTimeout( function(){ window.location.href = "index"; }, 2000);
               }else{
                 toastr.error(data, "Caution!");
               }
         
             $('#cmd_signup').attr('disabled', false);
             $('#cmd_signup').text('Signup');

      }


     });

     });


  $('#cmd_login').click(function (e) {
          e.preventDefault();
        
     $.ajax({
      url:"ajax/login.php",
      method: "POST",
      data:$('#login_form').serialize(),
      beforeSend: function(){
        //$(this).html('loading...');
        $("#cmd_login").attr('disabled', true);
        $("#cmd_login").text('logging in...');
      },
      success:function(data){
        //alert(data);
               if(data == 200){
                 toastr.success("Login was successful...", "Success!");
                 setTimeout( function(){ window.location.href = "home"; }, 2000);
               }else{
                 toastr.error(data, "Caution!");
               }
         
             $('#cmd_login').attr('disabled', false);
             $('#cmd_login').text('Login');

      }


     });

     });



    $('#cmd_create_member').click(function (e) {
          e.preventDefault();
        
     $.ajax({
      url:"ajax/create_member.php",
      method: "POST",
      data:$('#create_member_form').serialize(),
      beforeSend: function(){
        //$(this).html('loading...');
        $("#cmd_create_member").attr('disabled', true);
        $("#cmd_create_member").text('Please wait...');
      },
      success:function(data){
        //alert(data);
               if(data == 200){

                toastr.success("Member creation was successful", "Success!");
                setTimeout( function(){ window.location.href = "single_member_search.php"; }, 3000);

          

               }else{
               
                toastr.error(data, "Caution!");
              

               }

          $('#cmd_create_member').attr('disabled', false);
          $('#cmd_create_member').text('Create Member');

      }


     });
    
    });



 

   $('#cmd_edit_member').click(function (e) {
          e.preventDefault();
          var member_id = $('#member_id').val();
         // alert(member_id);
        
     $.ajax({
      url:"ajax/update_member.php",
      method: "POST",
      data:$('#edit_member_form').serialize(),
      beforeSend: function(){
        //$(this).html('loading...');
        $("#cmd_edit_member").attr('disabled', true);
        $("#cmd_edit_member").text('Please wait...');
      },
      success:function(data){
        //alert(data);
               if(data == 200){

                toastr.success("Member Update was successful", "Success!");
                // setTimeout( function(){ window.location.href = "edit_member.php?id="+member_id; }, 3000);
                setTimeout( function(){ window.location.href = "single_member_search.php"; }, 3000);

          

               }else{
               
                toastr.error(data, "Caution!");
              

               }

          $('#cmd_edit_member').attr('disabled', false);
          $('#cmd_edit_member').text('Update Member Profile');

      }


     });
    
    });
     


 
    




});


</script>

</body>

</html>