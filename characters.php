<?php

$config = include 'config.php';

function getTitle()
{
    return 'Karakterler';
}

$characters = file_get_contents("https://www.potterapi.com/v1/characters?key={$config['api_key']}");

$characterDetails = [];

$characters = json_decode($characters, true);

if (isset($_GET['house'])) {
    function filterByHouse($character) {
        if (isset($character['house']) && strtolower($character['house']) == strtolower($_GET['house'])) {
            return true;
        }
    }
    $characters = array_filter($characters, "filterByHouse");
}

foreach ($characters as $character) {
    $characterDetails[] = [
        'name' => $character['name'],
        'house' => $character['house'] ?? '',
        'role' => $character['role'] ?? '',
        'bloodStatus' => $character['bloodStatus'],
        'species' => $character['species']
    ];
}

?>

<?php

include 'header.php';

include 'navbar.php';

?>

<div class="pt-5">

    <div class="container">

        <section class="jumbotron text-center pt-5 mb-5 bg-white">
            <div class="container">
                <h1 class="jumbotron-heading"><?php echo getTitle(); ?></h1>
            </div>
        </section>


        <div class="bg-white p-5">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Role</th>
                    <th scope="col">House</th>
                    <th scope="col">Blood Status</th>
                    <th scope="col">Species</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $counter = 1;
                foreach ($characterDetails as $detail):
                    // if (isset($_GET['house']) && $_GET['house'] == strtolower($detail['house'])) {
                ?>
                        <tr>
                            <th scope="row"><?php echo $counter++; ?> </th>
                            <td><?php echo $detail['name']; ?></td>
                            <td><?php echo $detail['role']; ?></td>
                            <td><?php echo $detail['house']; ?></td>
                            <td><?php echo $detail['bloodStatus']; ?></td>
                            <td><?php echo $detail['species']; ?></td>
                        </tr>
                <?php
                    // }
                endforeach;
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php

include 'footer.php';

?>
