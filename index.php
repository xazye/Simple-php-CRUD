<?php

require './users/users.php';
$users = getUsers();

include "partials/header.php"
?>


<body>
    <div class="container ">
        <p>
            <a class="btn btn-outline-success mt-4" href="create.php">Create new User</a>
        </p>
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Website</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php if (isset($user['extension'])) : ?>
                                <img width="200px" src="<?php echo "users/images/{$user['id']}.{$user['extension']}" ?> " />
                            <?php endif; ?>
                        </td>

                        <td><?php echo $user['name'] ?></td>
                        <td>
                            <?php echo $user['username'] ?>
                        </td>
                        <td><?php echo $user['email'] ?></td>
                        <td>
                            <?php echo $user['phone'] ?>
                        </td>
                        <td><a target="_blank" href="http://<?php echo $user['website'] ?>">
                                <?php echo $user['website'] ?>
                            </a></td>
                        <td>
                            <a href="view.php?id=<?php echo $user['id'] ?>" class="btn btn-sm btn-outline-success">View</a>
                            <a href="update.php?id=<?php echo $user['id'] ?>" class="btn btn-sm btn-outline-secondary">Update</a>
                            <form style="display: inline-block;" method="POST" action="delete.php">
                                <input name="id" type="hidden" value="<?php echo $user['id'] ?>">
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>

                        </td>

                    </tr>
                <?php endforeach ?>
            </tbody>

        </table>

    </div>
    <?php include 'partials/footer.php' ?>