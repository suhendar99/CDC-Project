<div id="cart-button" class=" active">
	<div class="card bg-my-warning pointer rad-mod" onclick="showCart()">
		<div class="card-body">
			<center> 
				<i class="material-icons md-36">shopping_cart</i><br> 
				<div class="card d-flex justify-content-center py-1 px-2"> 
					<span class=" text-dark"> <span id="itemCount">1</span> Item </span>
				</div>
			</center>
		</div>
	</div>
</div>
<div id="cart-card">
	<div class="card cart-card rad-mod">
		<div class="card-header d-flex justify-content-between valign-center bg-my-warning"> 
			<span class=" card-title"> Keranjang Saya</span><span class="close pointer" onclick="hideCart()"><i class=" material-icons md-12">close</i></span>
		</div>
		<div class="card-body">
			<div class="cart-list">
				<div class="row">
					<div class="col-6">
						<img src="https://cf.shopee.co.id/file/08744f5b0e1ab3e2d537df5bbf5b2bb4" style="height:  100px">
					</div>
					<div class="col-6">
						<span class="product-name">Beras Super, 1Kg</span> 
						<span class="product-price">Rp. {{ number_format(10000,0,',','.')}}</span>
						<div id="qty" class=" valign-center mt-1"> 
							<i class=" material-icons pointer px-1 py-0" onclick=" decreaseOne()">remove_circle_outline</i>
							{{-- <div class=" qty-count"> 1</div> --}}
							<input type="text" name="qty" value="1" min="1" class="form-control" width="100">
							<i class=" material-icons pointer px-1 py-0" onclick=" increaseOne()">add_circle_outline</i>
						</div>
					</div>
				</div>
				<hr>
			</div>
			<div id="cart-footer"> 
				<div class=" w-100"> 
					<a href="#" class=" btn btn-warning bg-my-warning btn-block">
						Checkout
					</a>
				</div>
			</div>
		</div>
	</div>
</div>