<?php include ('scripts.php'); ?>

<script>

$( document ).ready(function() {
    alert();
});
function load_families (container, make_id, family_id)
			{
				alert();
				if(make_id != "")
				{
					if (family_id == 0 || typeof(family_id) == "undefined")
					{
						$("#"+container).find("#build_date").html("<option value='0'></option>");
						$("#"+container).find("#build_date").prop("disabled", true);
						$("#"+container).find("#vehicle").html("<option value='0'></option>");
						$("#"+container).find("#vehicle").prop("disabled", true);
						$("#"+container).find("#option").html("");

						var data = {
							make_id: make_id
						};						
					}
					else
					{
						var data = {
							make_id: make_id,
							family_id: family_id
						};
					}

					$.ajax({
						type: "POST",
						url: "<?php echo site_url("cars/load_families"); ?>",
						cache: false,
						data: data,
						success: function(response){
							$("#"+container).find("#family").removeAttr("disabled");
							$("#"+container).find("#family").html("<option value='0'></option>");
							$("#"+container).find("#family").append(response);
						}
					});				
				}
			}	
</script>