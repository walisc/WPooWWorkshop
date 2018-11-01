<?php
/*
 Template Name: Speaker Page
 *
*/
?>

<?php get_header(); ?>


<!-- Page Content -->
<div class="container">

    <!-- Introduction Row -->
    <h1 class="my-4">Speakers
    </h1>

    <div class="row">
        <?php
        $wc_speakers = wpAPIObjects::GetInstance()->GetObject("_wc_speakers");

        foreach ($wc_speakers->Query()->Select()->Fetch() as $speaker)
        {
            if ($speaker["_is_active"] == "on"){
            $photoData = json_decode($speaker["_photo"]);
            ?>

            <div class="col-lg-4 col-sm-6 text-center mb-4">
                <img class="rounded-circle img-fluid d-block mx-auto" style="width:auto; max-height: 200px" src="<?php echo $photoData->url ?>" alt="<?php echo $photoData->filename ?>">
                <h3><?php echo $speaker["_name"]?>
                    <small><?php echo $speaker["_wp_username"]?></small>
                </h3>
                <p><?php echo html_entity_decode(wpautop($speaker["_description"]))?> </p>
                <p><?php echo (is_array($speaker["_presenting_as"]) ? implode(',', $speaker["_presenting_as"]) : '')?> </p>

            </div>

            <?
            }
        }
        ?>
    </div>

</div>
<!-- /.container -->



<?php get_footer(); ?>
