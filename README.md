# WHMCS Addon - SIDN Suggestion Module #
SIDN Suggestion module for WHMCS

## Requirements and Authorization ##
To use the API you must request access by sending a request to support@sidn.nl or contacting your SIDN representative. When approved 
you will be provided with access to the API. The API uses the Client Authorization flow for server-side authorization. To start the authorization flow, you need to request a clientId and clientSecret. You can request these from SIDN Support. 

## Installation ##
### Initial setup ###
The easiest way to install this addon is by downloading the zip file from the releases and upload it's contents to the root of your WHMCS installation.

After this go to the folder using a cli to execute the following command: `composer install`, which will install the required dependensies.

### Template ###
This module assumes the following template to be available inside the /templates/orderforms/standard_cart/domainregister.tpl or at the location for your own template:
```HTML
<div class="sidn-suggestions suggested-domains">
    <div class="panel-heading card-header">
        {$suggestiontool_title}
    </div>
    <div class="list-group">
        <div class="domain-suggestion list-group-item w-hidden">
            <span class="domain"></span><span class="extension"></span>
            <div class="actions">
                <span class="price"></span>
                <button type="button" class="btn btn-add-to-cart" data-whois="1" data-domain="">
                    <span class="to-add">{$LANG.addtocart}</span>
                    <span class="loading">
                        <i class="fas fa-spinner fa-spin"></i> {lang key='loading'}
                    </span>
                    <span class="added"><i class="far fa-shopping-cart"></i> {lang key='checkout'}</span>
                </button>
            </div>
        </div>
    </div>
</div>
```

Furthermore add the following line in the bottom of the same file:
```HTML
<script src="{$sidnscriptpath}" type="text/javascript"></script>
```

### Configuration ###
Login to the admin dashboard and go to **System settings** > **Addon modules**

Click activate for the **SIDN Suggestion Tool** module. 

Now go to Configure and fill in the **Client ID** and **Client Secret** as aquired by SIDN and explained in the section [Requirements and Authorization](#requirements-and-authorization) above.
