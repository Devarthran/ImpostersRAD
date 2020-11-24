<?php 
    include_once 'includes/header.inc.php';
    if (!isset($_SESSION['adminName'])) {
        header('location:index.php');
        exit();
    }
    require_once 'includes/dbh.inc.php';
?>

<section>
    <div>
        <h1>Subscribers</h1>
        <table class="rtable">
            <thead>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Newsletters?</th>
                <th>Notifications?</th>
                <th>Is verified?</th>
                <th>Delete?</th>
            </thead>
            <tbody>

            
                <?php include_once 'includes/admin_tools/userTable.inc.php'?>
            </tbody>
        </table>
    </div>
</section>


<?php 
    include_once 'includes/footer.inc.php';
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("button").click(function()
        {
            var id = this.id;
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: 'includes/admin_tools/delUser.inc.php',
                    type: 'POST',
                    data: { id: id},
                    success: function(response) { 
                        alert(response);
                        location.reload();
                    }
                });
            }
        })
    })
</script>