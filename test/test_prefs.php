#! /usr/local/bin/php
<?php
    // test preferences
    //

    include_once("init.inc");

    clear_db();
    clear_data_dirs();
    init_client_dirs("account1.xml");
    copy_to_download_dir("small_input");
    add_platform();
    add_core_client();
    add_user();
    add_prefs("laptop_prefs.xml");
    add_app("uc_slow");
    create_work("-appname uc_slow -wu_name ucs_wu -wu_template ucs_wu -result_template ucs_result -nresults 1 small_input");
    echo "Now run the client manually; start and stop it a few times.\n";
    //run_client();
    //compare_file("ucs_wu_0_0", "uc_small_correct_output");
?>
