<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/bs.css">
    <title>Alumni Profile</title>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-5">
                    <div class="card-body">
                        <h3 class="card-title text-center">Edit Admin Profile</h3>
                        <hr>
                        <?php if (isset($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                        <?php endif; ?>
                        <form method="POST" action="save_admin.php" enctype="multipart/form-data">
                            <input type="hidden" name="ID1" value="<?php echo $ID1; ?>" />
                            <input type="hidden" name="admin_id" value="<?php echo $adminId; ?>" />
                            <div class="row my-3">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="profile_picture">Profile Picture</label>
                                        <input type="file" class="form-control" id="profile_picture"
                                            name="profile_picture">
                                    </div>

                                    <div class="form-group">
                                        <label for="cstatus">Civil Status</label>
                                        <select class="form-select" id="cstatus" name="cstatus"
                                            value="<?php echo $cstatus; ?>">
                                            <option value="single">Single</option>
                                            <option value="married">Married</option>
                                            <option value="divorced">Divorced</option>
                                            <option value="widowed">Widowed</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            value="<?php echo $address; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="contactNumber">Contact Number</label>
                                        <input type="text" class="form-control" id="contactNumber" name="contactNumber"
                                            value="<?php echo $address; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?php echo $email; ?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="contact_num">Contact Number</label>
                                        <input type="text" class="form-control" id="contact_num" name="contact_num"
                                            value="<?php echo $contact_num; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="work">Works</label>
                                        <input type="text" class="form-control" id="work" name="work"
                                            value="<?php echo $work; ?>">
                                    </div>

                                </div>
                                <div class="py-3 text-end">
                                    <button type="submit" class="btn btn-primary w-25">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap/bs.js"></script>
    <script>
    const contactNumberInput = document.getElementById('contactNumber');

    contactNumberInput.addEventListener('input', function() {
        let contactNumber = contactNumberInput.value.replace(/\D/g, '');

        if (contactNumber.length >= 2 && !contactNumber.startsWith('+63')) {
            contactNumber = '+63' + contactNumber.slice(2);
        }

        contactNumber = contactNumber.slice(0, 13);

        contactNumberInput.value = contactNumber;
    });
    </script>
</body>

</html>