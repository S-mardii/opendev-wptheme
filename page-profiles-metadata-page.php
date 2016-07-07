<div class="container">
    <div class="row no-margin-top">
      <div class="twelve columns profiles_page profile-metadata">
        <h2 class="align-left h2_name"><?php _e("Metadata:", "opendev"); the_title() ?></h2>
        <div class="clear"></div>
        <?php
      $showing_fields = array(
              "notes_translated" => "Description",
              "odm_source" => "Source(s)",
              "odm_date_created" => "Date created",
              "odm_temporal_range" => "Temporal range",
              "odm_process" => "Process(es)",
              "odm_logical_consistency" => "Logical Consistency",
              "odm_completeness" => "Completeness",
              "odm_access_and_use_constraints" => "Access and use constraints",
              "odm_copyright" => "Copyright",
              "license_id" => "License",
              "odm_attributes" => "Attributes"
                  );
        get_metadata_info_of_dataset_by_id(CKAN_DOMAIN,$metadata_dataset, '', 0, $showing_fields);
      
       ?>
      </div>
    </div>
</div>
