<?php
/*
Template Name: Laws page
*/
?>

<?php
require_once('page-laws-config.php');

function get_law_datasets($ckan_domain,$filter_key,$filter_value){

  $filters = array(
    "type" => "laws_record",
  );

  if (isset($filter_key)):
    $filters[$filter_key] = $filter_value;
  endif;

  return wpckan_get_datasets_filters($ckan_domain,$filters);

}

?>

<?php get_header(); ?>

<?php if(have_posts()) : the_post(); ?>

  <?php
    $filter_odm_document_type = NULL;
    if (isset($_GET["odm_document_type"])){
      $filter_odm_document_type = htmlspecialchars($_GET["odm_document_type"]);
    }
    $filter_odm_taxonomy = NULL;
    if (isset($_GET["odm_taxonomy"])){
      $filter_odm_taxonomy = htmlspecialchars($_GET["odm_taxonomy"]);
    }
    $laws = array();
    if (!IsNullOrEmptyString($filter_odm_taxonomy)){
      $laws = get_law_datasets($CKAN_DOMAIN,"extras_taxonomy",$filter_odm_taxonomy);
    }else if (!IsNullOrEmptyString($filter_odm_document_type)){
      $laws = get_law_datasets($CKAN_DOMAIN,"odm_document_type",$filter_odm_document_type);
    }else{
      $laws = get_law_datasets($CKAN_DOMAIN,NULL,NULL);
    }

    $lang = 'en';
    $headline = $filter_odm_taxonomy;

    if (function_exists("qtranxf_getLanguage")){
      $lang = qtranxf_getLanguage();
    }

    // NOTE: This is a hack to harmonize language code between WP and CKAN.
    // Current country code for CAmbodia is set to KH on WP, after that is moved to KM, this needs to be replaced.
    if ($lang == "kh"){
      $lang = "km";
    }

  ?>

  <section id="content" class="single-post">
    <header class="single-post-header">
			<div class="twelve columns">
        <h1 class=""><a href="<?php get_page_link(); ?>"><?php the_title(); ?></a></h1>
        <h2 class=""><?php _e( $headline, 'opendev' ); ?></h2>
			</div>
		</header>
		<div class="container">
			<div class="nine columns">
        <!-- <?php //print_r($laws); ?> -->
        <?php the_content(); ?>
        <table id="law_datasets" class="data-table">
          <thead>
            <tr>
              <th><?php _e( 'Title', 'opendev' );?></th>
              <th><?php _e( 'Document type', 'opendev' );?></th>
              <th><?php _e( 'Document number', 'opendev' );?></th>
              <th><?php _e( 'Promulgation date', 'opendev' );?></th>
              <th><?php _e( 'Download', 'opendev' );?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($laws as $law_record): ?>
              <?php if (IsNullOrEmptyString($law_record['odm_document_type'])){
                continue;
              }?>
              <tr>
                <td class="entry_title">
                  <a href="<?php echo $CKAN_DOMAIN . "/dataset/" . $law_record['id'];?>"><?php echo getMultilingualValueOrFallback($law_record['title_translated'],$lang);?></a>
                </td>
                <td>
                  <?php
                    if (isset($law_record['odm_document_type'])){
                      $doc_type = $law_record['odm_document_type'];
                      echo _e( $LAWS_DOCUMENT_TYPE[$doc_type], 'opendev' );
                    }
                  ?>
                </td>
                <td>
                  <?php
                  if (isset($law_record['odm_document_number'])){
                    echo $law_record['odm_document_number'][$lang];
                  }?>
                </td>
                <td>
                  <?php
                  if (isset($law_record['odm_promulgation_date'])){
                      if (function_exists('qtranxf_getLanguage') && ((qtranxf_getLanguage() == "kh") || (qtranxf_getLanguage == "km"))){
                          echo convert_date_to_kh_date(date("d.m.Y", strtotime($law_record['odm_promulgation_date'])));
                      }else{
                        echo ($law_record['odm_promulgation_date']);
                    }
                   }
                  ?>
                </td>
                <td class="download_buttons">
                    <?php foreach ($law_record['resources'] as $resource) :?>
                      <?php if ( isset($resource['odm_language']) && $resource['odm_language'][0] == 'en'){?>
                        <span><a href="<?php echo $resource['url'];?>">
                          <span class="icon-arrow-down"></span>EN</a></span>
                      <?php } ?>
                    <?php endforeach; ?>
                    <?php foreach ($law_record['resources'] as $resource) :?>
                      <?php if ( isset($resource['odm_language']) && $resource['odm_language'][0] == 'km'){?>
                        <span><a href="<?php echo $resource['url'];?>">
                          <span class="icon-arrow-down"></span>KM</a></span>
                      <?php } ?>
                    <?php endforeach; ?>
                </td>
              </tr>
    				<?php endforeach; ?>
  				</tbody>
  			</table>
			</div>
			<div class="three columns">

				<div class="sidebar_box">
					<div class="sidebar_header">
            <?php if( $headline ) { ?>
              <h2><?php _e( 'SEARCH', 'opendev' );?> <?php _e( 'Laws in', 'opendev' );?> <?php _e( $headline , 'opendev' ); ?></h2>
            <?php }else { ?>
	               <h2><?php _e( 'SEARCH', 'opendev' );?></h2> <?php _e( 'in Laws', 'opendev' ); ?>
           <?php } ?>
					</div>
					<div class="sidebar_box_content">
						<input type="text" id="search_all" placeholder=<?php _e( "Search all Laws", 'opendev');?>>
            <?php if (!IsNullOrEmptyString($filter_odm_document_type) || !IsNullOrEmptyString($filter_odm_taxonomy)): ?>
              <a href="/laws"><?php _e( 'Clear filter', 'opendev' ) ?>
            <?php endif; ?>
					</div>
				</div>

        <div class="sidebar_box">
					<div class="sidebar_header">
						<h2><?php _e( 'LAW COMPENDIUM', 'opendev' );?></h2>
					</div>
					<div class="sidebar_box_content">
            <?php echo buildStyledTopTopicListForLaws($lang); ?>
					</div>
				</div>

        <div class="sidebar_box law_search_box">
					<div class="sidebar_header">
						<h2><?php _e( 'TYPE OF LAWS', 'opendev' );?></h2>
					</div>
					<div class="sidebar_box_content">
            <ul>
              <li><a href="/laws/?odm_document_type=anukretsub-decree"><?php _e( 'Anukret/Sub-Decree', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=chbablawkram"><?php _e( 'Chbab/Law/Kram', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=constitution-of-cambodia"><?php _e( 'Constitution of Cambodia', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=international-treatiesagreements"><?php _e( 'International Treaties/Agreements', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=kech-sonyacontractagreement"><?php _e( 'Kech Sonya/Contract/Agreement', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=kolkar-nenomguidelines"><?php _e( 'Kolkar Nenom/Guidelines', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=kolnyobaypolicy"><?php _e( 'Kolnyobay/Policy', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=likhetletter"><?php _e( 'Likhet/Letter', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=prakasjoint-prakasproclamation"><?php _e( 'Prakas/Joint-Prakas/Proclamation', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=preah-reach-kramroyal-kram"><?php _e( 'Preah Reach Kram/Royal Kram', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=sarachorcircular"><?php _e( 'Sarachor/Circular', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=sechkdei-chhun-damneoungnoticeannouncement"><?php _e( 'Sechkdei Chhun Damneoung/Notice/Announcement', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=sechkdei-nenuminstruction"><?php _e( 'Sechkdei Nenum/Instruction', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=sechkdei-preang-chbabdraft-laws-amp-regulations"><?php _e( 'Sechkdei Preang Chbab/Draft Laws & Regulations', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=sechkdei-samrechdecision"><?php _e( 'Sechkdei Samrech/Decision', 'opendev' );?></a></li>
              <li><a href="/laws/?odm_document_type=others"><?php _e( 'Others', 'opendev' );?></a></li>
            </ul>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php get_footer(); ?>

<script type="text/javascript">

jQuery(document).ready(function($) {

  console.log("laws pages init");

  $.fn.dataTableExt.oApi.fnFilterAll = function (oSettings, sInput, iColumn, bRegex, bSmart) {
   var settings = $.fn.dataTableSettings;
   for (var i = 0; i < settings.length; i++) {
     settings[i].oInstance.fnFilter(sInput, iColumn, bRegex, bSmart);
   }
  };

  var oTable = $("#law_datasets").dataTable({
    scrollX: false,
    responsive: true,
    dom: '<"top"<"info"i><"pagination"p><"length"l>>rt',
    processing: true,
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    order: [[ 0, 'asc' ]],
    displayLength: 25

    <?php if (CURRENT_LANGUAGE == "km" || CURRENT_LANGUAGE == "kh"){?>
      , "oLanguage": {
        "sLengthMenu": 'បង្ហាញចំនួន​ <select>'+
            '<option value="10">១០</option>'+
            '<option value="25"> ២៥</option>'+
            '<option value="50"> ៥០</option>'+
            '<option value="-1">ទាំងអស់</option>'+
        '</select> ក្នុងមួយទំព័រ',
        "sZeroRecords": "ព័ត៌មានពុំអាចរកបាន",
        "sInfo":"បង្ហាញពីទី _START_ ដល់ _END_ នៃចំនួនសរុប _TOTAL_",
        "sInfoFiltered": "(ទាញចេញពីទិន្នន័យច្បាប់សរុបចំនួន _MAX_)",
        "sSearch":"ស្វែងរក",
        "oPaginate": {
            "sFirst": "ទំព័រដំបូង",
            "sLast": "ចុងក្រោយ",
            "sPrevious": "មុន",
            "sNext": "បន្ទាប់"
            }
        }
    <?php } ?>
  });

  $("#search_all").keyup(function () {
    console.log("filtering page " + this.value);
    oTable.fnFilterAll(this.value);
 });

});

</script>
