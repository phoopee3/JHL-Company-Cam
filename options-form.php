<h1>Company Cam API Settings</h1>

<form class="jhl-cc" method="POST">
    <?php wp_nonce_field( 'jhl_cc_option_page_update' ); ?>

    <div>
        <label for="jhl_cc_api_key"><strong>API Key</strong></label>
        <?php $jhl_cc_api_key = get_option( 'jhl_cc_api_key', '' ); ?>
        <input type="text" name="jhl_cc_api_key" id="jhl_cc_api_key" value="<?php echo $jhl_cc_api_key; ?>">
    </div>

    <div>
        <label for="jhl_cc_project_id"><strong>Project ID</strong></label>
        <?php $jhl_cc_project_id = get_option( 'jhl_cc_project_id', '' ); ?>
        <input type="text" name="jhl_cc_project_id" id="jhl_cc_project_id" value="<?php echo $jhl_cc_project_id; ?>">
    </div>

    <div>
        <label for="jhl_cc_api_base"><strong>API Base</strong></label>
        <?php $jhl_cc_api_base = get_option( 'jhl_cc_api_base', '' ); ?>
        <input type="text" name="jhl_cc_api_base" id="jhl_cc_api_base" value="<?php echo $jhl_cc_api_base; ?>">
    </div>

    <div>
        <label for="jhl_cc_api_endpoint"><strong>API Endpoint</strong></label>
        <?php $jhl_cc_api_endpoint = get_option( 'jhl_cc_api_endpoint', '' ); ?>
        <input type="text" name="jhl_cc_api_endpoint" id="jhl_cc_api_endpoint" value="<?php echo $jhl_cc_api_endpoint; ?>">
    </div>

    <div>
        <label for="jhl_cc_user_email"><strong>User Email (for header)</strong></label>
        <?php $jhl_cc_user_email = get_option( 'jhl_cc_user_email', '' ); ?>
        <input type="text" name="jhl_cc_user_email" id="jhl_cc_user_email" value="<?php echo $jhl_cc_user_email; ?>">
    </div>

    <input type="submit" value="Save" class="button button-primary button-large">

    <style>
    form.jhl-cc > div {
        padding-bottom : 15px;
    }
    form.jhl-cc label {
        display: inline-block;
        width: 230px;
    }
    </style>
</form>
