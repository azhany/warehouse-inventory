
function suggetion() 
{
     $('#sug_input').keyup(function(e) {
         var formData = {
             'product_name' : $('input[name=title]').val()
         };
         if(formData['product_name'].length >= 1) {
           // process the form
           $.ajax({
               type        : 'POST',
               url         : 'ajax.php',
               data        : formData,
               dataType    : 'json',
               encode      : true
           }).done(function(data) {
			   //console.log(data);
			   $('#result').html(data).fadeIn();
			   $('#result li').click(function() {

				 $('#sug_input').val($(this).text());
				 $('#result').fadeOut(500);

			   });

			   $("#sug_input").blur(function(){
				 $("#result").fadeOut(500);
			   });
		   });
         } else {
           $("#result").hide();
         };

         e.preventDefault();
     });
}
  
  function total()
  {
    $('#product_info input').bind('change', function(e)  {
		var parent_id = $(this).parents('tr').attr('id');
		//alert(parent_id);
		var price = +$('#product_info tr#' + parent_id).find('.s_price').children().val() || 0;
		var qty   = +$('#product_info tr#' + parent_id).find('.s_qty').children().val() || 0;
		var total = qty * price;
		$('#product_info tr#' + parent_id).find('.s_total').children().val(total.toFixed(2));
		if($( "#product_info" ).children().length > 0) {
			var subtotal = 0;
			$( "#product_info" ).each(function( index ) {
				subtotal += +$(this).find('.s_total').children().val();
			});
			
			$('input[name=subtotal]').val(subtotal.toFixed(2));
			var discount   = +$('input[name=discount]').val() || 0;
			var grandtotal = +subtotal - ((+discount/100) * +subtotal);
			$('input[name=grandtotal]').val(grandtotal.toFixed(2));
			grandtotal_calculation();
		}
    });
	
	if($( "#product_info" ).children().length > 0) {
		var subtotal = 0;
		$( "#product_info" ).each(function( index ) {
			subtotal += +$(this).find('.s_total').children().val();
		});
		
		$('input[name=subtotal]').val(subtotal.toFixed(2));
		var discount   = +$('input[name=discount]').val() || 0;
		var grandtotal = +subtotal - ((+discount/100) * +subtotal);
		$('input[name=grandtotal]').val(grandtotal.toFixed(2));
	}
  }
  
  function remove(p_id)
  {
	  $('tr#'+p_id).remove();
  }
  
  function grandtotal_calculation()
  {
	$('input[name=discount]').bind('change', function(e) {
		var subtotal = +$('input[name=subtotal]').val() || 0;
		var discount   = +$('input[name=discount]').val() || 0;
		var grandtotal = subtotal - ((discount/100) * subtotal);
		$('input[name=grandtotal]').val(grandtotal.toFixed(2));
	});
  }

  $(document).ready(function() {
    //tooltip
    $('[data-toggle="tooltip"]').tooltip();

    $('.submenu-toggle').click(function () {
       $(this).parent().children('ul.submenu').toggle(200);
    });
    //suggetion for finding product names
    suggetion();
    // Callculate total ammont
    total();
	grandtotal_calculation();
	
	  $('#sug-form').submit(function(e) {
		  var formData = {
			  'p_name' : $('input[name=title]').val()
		  };
			// process the form
			$.ajax({
				type        : 'POST',
				url         : 'ajax.php',
				data        : formData,
				dataType    : 'json',
				encode      : true
			}).done(function(data) {
				//console.log(data);
				$('#product_info').append(data).show();
				total();
				//$('.datePicker').datepicker('update', new Date());

			}).fail(function() {
				$('#product_info').html(data).show();
			});
		  e.preventDefault();
	  });
  
	   $('#cus-form').on('change', function(e) {
		  var formData = {
			  'customer_name' : $('input[name=customer_name]').val()
		  };
			// process the form
			$.ajax({
				type        : 'POST',
				url         : 'ajax.php',
				data        : formData,
				dataType    : 'json',
				encode      : true
			}).done(function(data) {
				//console.log(data);
				$('#cus_input').html(data).show();
				total();

			}).fail(function() {
				$('#cus_input').html(data).show();
			});
		  e.preventDefault();
	  });

    $('.datepicker')
        .datepicker({
			setDate: new Date(),
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true
        });
		
	$('select[name="customer"]').select2();
	$('select[name="payment_method"]').select2();
	$('select[name="customer"]').on('change', function() {
        $.ajax({
            type        : 'POST',
            url         : 'ajax.php',
            data        : { 'customer_id' : $(this).val() },
            dataType    : 'json',
            encode      : true
        }).done(function(data) {
			//console.log(data.address);
			if(data !== null)
				$('textarea[name="shipping_address"]').html(data.address).show();
			else
				$('textarea[name="shipping_address"]').html('').show();
			
			//total();
			grandtotal_calculation();
		}).fail(function() {
			$('textarea[name="shipping_address"]').html('').show();
		});
	});
  });
