<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="location = '<?php echo $insert; ?>'" class="button"><?php echo $button_insert; ?></a><a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
	<input hidden id="page" value="<?php echo $page ?>">
	<input hidden id="sort" value="<?php echo $sort ?>">
	<input hidden id="order" value="<?php echo $order ?>">
        <table class="list">
          <thead>
            <tr id="head">
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php echo $column_site_url?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
       
            <?php if ($records) { ?>
              <?php foreach ($records as $record) { ?>
              <tr>
                <td style="text-align: center;"><?php if ($product['selected']) { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $record['id']; ?>" checked="checked" />
                  <?php } else { ?>
                  <input type="checkbox" name="selected[]" value="<?php echo $record['id']; ?>" />
                  <?php } ?></td>
              
                <td class="left"><?php echo $record['url']; ?></td>
                <td class="right"><?php foreach ($record['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="center" colspan="10"><?php echo $text_no_results; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script id="productTemplate" type="text/x-jquery-tmpl">
<tr>
              <td style="text-align: center;">
                <input type="checkbox" name="selected[]" value="${product_id}" />
              </td>
              <td class="center"><img src="${image}" alt="${name}" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
	      <td class="left">{{each(i, cat) category}}${cat['name']}<br/>{{/each}}</td>
	      <td class="left">${manufacturer}</td>
              <td class="left">${name}</td>
              <td class="left">${model}</td>
              <td class="left">{{if special}}
                <span style="text-decoration: line-through;">${price}</span><br/>
                <span style="color: #b00;">${special}</span>
                {{else}}
                ${price}
                {{/if}}
	      </td>
              <td class="right">
		      {{if quantity <= 5}}
			      {{if quantity <= 0}}
				      <span style="color: #FF0000;">${quantity}</span>
			      {{else}}
				      <span style="color: #FFA500;">${quantity}</span>
			      {{/if}}
		      {{else}}
			      <span style="color: #008000;">${quantity}</span>
		      {{/if}}
              </td>
              <td class="left">${status}</td>
              <td class="right">
		{{each action}}
			[ <a href="${href}">${text}</a> ]
                {{/each}}
	      </td>
            </tr>
</script>
<script type="text/javascript" src="view/javascript/jquery/jquery.tmpl.min.js"></script>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=catalog/product/filter&token=<?php echo $token; ?>';

	url += '&page=' + $('#page').val();

	if ($('#sort').val()) {
		url += '&sort=' + $('#sort').val();
	}
	if ($('#order').val()) {
		url += '&order=' + $('#order').val();
	}
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_model = $('input[name=\'filter_model\']').attr('value');
	
	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}
	
	var filter_price = $('input[name=\'filter_price\']').attr('value');
	
	if (filter_price) {
		url += '&filter_price=' + encodeURIComponent(filter_price);
	}
	
	var filter_quantity = $('input[name=\'filter_quantity\']').attr('value');
	
	if (filter_quantity) {
		url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
	}
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}	

	var category_id = $('select[name=\'filter_category_id\']').attr('value');
	
	if (category_id != '*') {
		url += '&filter_category_id=' + encodeURIComponent(category_id);
	}	

	var manufacturer_id = $('select[name=\'filter_manufacturer_id\']').attr('value');
	
	if (manufacturer_id != '*') {
		url += '&filter_manufacturer_id=' + encodeURIComponent(manufacturer_id);
	}	

	$.ajax({
		url: url,
		dataType: 'json',
		success : function(json) {
				  $('table.list tr:gt(1)').empty();
				  $("#productTemplate").tmpl(json.products).appendTo("table.list");
				  $('.pagination').html(json.pagination);
			  }
	});
}
//--></script> 
<script type="text/javascript"><!--

function gsUV(e, t, v) {
    var n = String(e).split("?");
    var r = "";
    if (n[1]) {
        var i = n[1].split("&");
        for (var s = 0; s <= i.length; s++) {
            if (i[s]) {
                var o = i[s].split("=");
                if (o[0] && o[0] == t) {
                    r = o[1];
                    if (v != undefined) {
                        i[s] = o[0] +'=' + v;
                    }
                    break;
                }
            }
        }
    }
    if (v != undefined) {
        return n[0] +'?'+ i.join('&');
    }
    return r
}
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#page').val(1);
		filter();
	}
});
$('#form input').bind("input", function() {
	if ($(this).val()=='') {
		$('#page').val(1);
		filter();
	}
});

$('#form select').bind("change", function() {
	$('#page').val(1);
	filter();
});

$('.pagination .links a').live("click", function() {
	var page = gsUV($(this).attr('href'), 'page');
	$('#page').val(page);
	filter();
	return false;
});

$('#head a').live("click", function() {

	var sort = gsUV($(this).attr('href'), 'sort');
	$('#sort').val(sort);
	var order = gsUV($(this).attr('href'), 'order');
	$('#order').val(order);
	$(this).attr('href', gsUV($(this).attr('href'), 'order', order=='DESC'?'ASC':'DESC'));
	$('#head a').removeAttr('class');
	this.className = order.toLowerCase();
	filter();
	return false;
});
function clear_filter() {
	$('tr.filter select option:selected').prop('selected', false);
	$('tr.filter input').val('');
	filter();
	return false;
}
//--></script> 
<script type="text/javascript"><!--
$('.filter input').autocomplete({
	delay: 500,
	source: function(request, response) {
	    filter();
	}
});

//--></script> 
<?php echo $footer; ?>