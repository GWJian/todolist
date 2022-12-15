<?php

    $database = new PDO(
        'mysql:host=devkinsta_db;
        dbname=todolist',
        'root',
        '4JqGyoVdUoAAEJxU'
    );

    // grap from SQL
    $query = $database->prepare('SELECT * FROM todolist');
    $query-> execute();
    $todolist_00 = $query->fetchAll();

    if(
        $_SERVER['REQUEST_METHOD'] === 'POST'
    ){
        if ($_POST['action']==='add')
        {
            //add 
            $statement = $database -> prepare(
                "INSERT INTO todolist (`name`) 
                VALUES (:name)"
            );
            $statement -> execute([
                'name' => $_POST['todolist']
            ]);
    
            header('Location:/');
            exit;
        }

        if ($_POST['action'] === 'delete')
        {
            //delete 
            $statement = $database->prepare(
                'DELETE FROM todolist WHERE id = :id'
            );

            $statement->execute([
                'id' => $_POST['todolist_id']
            ]);

            header('Location:/');
            exit;
        }
        
    }

?>


<!DOCTYPE html>
<html>

<head>
    <title>TODO App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" />
    <style type="text/css">
    body {
        background: #f1f1f1;
    }

    /* <!-- =============----Strike-through on click----================== --> */
    input[id=check_box]:checked~p.check_box {
        text-decoration: line-through;
        color: black;
    }
    </style>

</head>

<body>
    <div class="card rounded shadow-sm" style="max-width: 500px; margin: 60px auto;">
        <div class="card-body">
            <h3 class="card-title mb-3">My Todo List</h3>
            <!-- delete -->
            <?php foreach ($todolist_00 as $todolist): ?>
                <div class="d-flex justify-content-between gap-3">
                <!-- =============----Strike-through on click----================== -->
                    <div class="d-flex justify-contect-center align-items-center">
                        <input class="form-check-input mt-0" type="checkbox" value=""
                        aria-label="Checkbox for following text input" id="check_box">
                        <p class="check_box m-0"><?php echo $todolist['name']; ?></p>
                    </div>
                <!-- =============----Strike-through on click----================== -->

                    <form action="<?php echo $_SERVER
                        ['REQUEST_URI']; ?>" method="POST">
                        <input type="hidden" name="todolist_id" value="<?php echo $todolist ['id']; ?>">
                        <input type="hidden" name="action" value="delete">
                        <button class="btn btn-danger mb-1">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>




            <!-- add -->
            <div class="mt-4">
                <form method="POST" action="<?php echo $_SERVER['REQUEST_URI'] ?>"
                    class="mt-4 d-flex justify-content-between align-items-center">
                    <input type="text" class="form-control" placeholder="Add new todolist..." name="todolist"
                        required />
                    <input type="hidden" name="action" value="add">
                    <button class="btn btn-primary btn-sm rounded ms-2">Add</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>