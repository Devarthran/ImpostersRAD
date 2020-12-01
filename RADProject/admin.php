<?php
include_once 'includes/header.inc.php';
if (!isset($_SESSION['access_level'])) {
    header('location:index.php');
    exit();
} else {
    $access_level = $_SESSION['access_level'];
}
require_once 'includes/dbh.inc.php';

?>

<section id="tableSubscribers">
    <div>
        <h2>Subscribers</h2>
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
                <?php include_once 'includes/admin_tools/userTable.inc.php' ?>
            </tbody>
        </table>
    </div>
</section>

<?php
if ($access_level <= 1) {
    include_once 'includes/admin_tools/staff_table.inc.php';
}
?>

<?php
include_once 'includes/footer.inc.php';
?>
<script type="text/javascript">
    $(document).ready(function() {
        $(".btnDelUser").click(function() {
            var id = this.id;
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: 'includes/admin_tools/delUser.inc.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        alert(response);
                        location.reload();
                    }
                });
            }
        });
        $('.btnDeleteStaff').click(function() {
            var id = this.id;
            if (confirm("Are you sure?")) {
                $.ajax({
                    url: 'includes/admin_tools/delStaff.inc.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        alert(response);
                        location.reload();
                    }
                });
            }
        });
    })
</script>