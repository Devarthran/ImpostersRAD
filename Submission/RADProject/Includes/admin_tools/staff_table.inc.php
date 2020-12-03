<input  class="form-news-inputs" type="button" id='btnShowStaffModal' value="Create Staff"></input>
<section id="modalStaffCreate" class="modal">
    <div class="modal-content">
        <span id="closeStaffCreate" class="close">&times;</span>
        <form id="formUpdate" onsubmit="return validateStaff(this)">
            <h2>Create Staff Account</h2>
            <div><input class="form-news-inputs" type="text" name="fullName" placeholder="Full name..." required></div>
            <div><input class="form-news-inputs" type="email" name="email" placeholder="Email..." required></div>
            <div><input class="form-news-inputs" type="password" name="password" placeholder="Password..." pattern="^([a-z+A-z+\d+]+){8,20}$" required></div>
            <p>Password must be at least 8 characters with at least one number, one uppercase</p>
            <div><input class="form-news-inputs" type="number" name="access_level" placeholder="Access level..." min="1" max="3" pattern="[1-3]{1}" required></div>
            
            <div><input type="submit" name="btnCreateStaff"></div>
            <p id="messageStaff"></p>
        </form>
    </div>
</section>

<section id="table-Staff">
    <div>
        <h2>Staff</h2>
        <table class="rtable">
            <thead>
                <th>Staff ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Access Level</th>
                <th>Delete?</th>
            </thead>
            <tbody>
                <?php 
                
                require_once 'includes/dbh.inc.php';
                require_once 'adminFunctions.inc.php';

                $staff = fetchStaff($conn);

                while ($row = mysqli_fetch_assoc($staff)) {
                    $id = $row['staffId'];
                    $name = $row['staffName'];
                    $email = $row['staffEmail'];
                    $al = $row['access_level'];

                    echo <<< HTML
                        <tr>
                            <td>$id</td>
                            <td>$name</td>
                            <td>$email</td>
                            <td>$al</td>
                            <td>
                                <button class='btnDeleteStaff' type='submit' id='$id'>Delete?</button>
                            </td>
                        </tr>
                    HTML;



                }
                
                ?>
            </tbody>
        </table>
    </div>
</section>
<script type="text/javascript" src="js/admin.php.js"></script>