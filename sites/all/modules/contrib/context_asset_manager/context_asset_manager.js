(function($){
  $(function(){
    //alert(345);
    // Show/hide core elements depending on the selection
    if($('input[name=context_asset_manager_include_core_assets]').is(":checked")){
      $('div.form-item-context-asset-manager-scan-core-modules').show();
      $('div.form-item-context-asset-manager-purge-css-full').show();
      $('div.form-item-context-asset-manager-purge-js-full').show();
    } else {
        $('div.form-item-context-asset-manager-scan-core-modules').hide();
        $('div.form-item-context-asset-manager-purge-css-full').hide();
        $('div.form-item-context-asset-manager-purge-js-full').hide();
        $('#edit-context-asset-manager-purge-css-full').prop('checked',false);
        $('#edit-context-asset-manager-purge-js-full').prop('checked',false);
        $('div#edit-context-asset-manager-scan-core-modules').find('input[type=checkbox]').prop('checked',false);
    }

    $('input[name=context_asset_manager_include_core_assets]').change(function(){
      if($(this).is(':checked')){
        $('div.form-item-context-asset-manager-scan-core-modules').show();
        $('div.form-item-context-asset-manager-purge-css-full').show();
        $('div.form-item-context-asset-manager-purge-js-full').show();
      } else {
        $('div.form-item-context-asset-manager-scan-core-modules').hide();
        $('div.form-item-context-asset-manager-purge-css-full').hide();
        $('div.form-item-context-asset-manager-purge-js-full').hide();
        $('#edit-context-asset-manager-purge-css-full').prop('checked',false);
        $('#edit-context-asset-manager-purge-js-full').prop('checked',false);
        $('div#edit-context-asset-manager-scan-core-modules').find('input[type=checkbox]').prop('checked',false);
      }
    });

    // Select/de-select functionality
    $('input[id=edit-context-asset-manager-scan-contrib-modules-contrib-select-all]').change(function(){
      if($(this).is(':checked')){
        $('div#edit-context-asset-manager-scan-contrib-modules').find('input[type=checkbox]').prop('checked', true);

      } else {
        $('div#edit-context-asset-manager-scan-contrib-modules').find('input[type=checkbox]').prop('checked',false);
      }
    });
    $('input[id=edit-context-asset-manager-scan-core-modules-core-select-all]').change(function(){
      if($(this).is(':checked')){
        $('div#edit-context-asset-manager-scan-core-modules').find('input[type=checkbox]').prop('checked',true);
      } else {
        $('div#edit-context-asset-manager-scan-core-modules').find('input[type=checkbox]').prop('checked',false);
      }
    });

    $('div#edit-context-asset-manager-scan-contrib-modules').find('input[type=checkbox][id!=edit-context-asset-manager-scan-contrib-modules-contrib-select-all]').click(function(){
      if($(this).prop('checked') == false){
        $('input[id=edit-context-asset-manager-scan-contrib-modules-contrib-select-all]').prop('checked', false);
      }
    });

    $('div#edit-context-asset-manager-scan-core-modules').find('input[type=checkbox][id!=edit-context-asset-manager-scan-core-modules-core-select-all]').click(function(){
      if($(this).prop('checked') == false){
        $('input[id=edit-context-asset-manager-scan-core-modules-core-select-all]').prop('checked', false);
      }
    });
 });
})(jQuery);
