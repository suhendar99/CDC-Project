function showCart() {
	$('#cart-card').toggleClass('active');
	$('#cart-button').toggleClass('active');
}

function hideCart() {
	$('#cart-card').toggleClass('active');
	$('#cart-button').toggleClass('active');
}

function increaseOne(){
	let before = $('[name="qty"]').val();
	console.log(before)
	console.log($('[name="qty"]').val(parseInt(before)+1));
}
function decreaseOne(){
	let before = $('[name="qty"]').val();
	console.log(before)
	if ( before > 1) {
		console.log($('[name="qty"]').val(before-1));
	}
}