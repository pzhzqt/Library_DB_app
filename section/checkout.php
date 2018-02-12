		<div class="tableheader">
			<h1>Book Checkout</h1>
		</div>
		<form action="result.php"
			  class="search-form"
			  method="post">
			<div class="div-col">
				<input type="text" placeholder="BookID" name="bookid">
				<input type="text" placeholder="StudentID" name="studentid">
				<div class="searchtype">
					<input type="submit" name="checkout" value="Checkout">
				</div>
			</div>
        </form>
		<div class="tableheader">
			<h1>Book Return</h1>
		</div>
		<form action="result.php"
			  class="search-form"
			  method="post">
			<div class="div-col">
				<input type="text" placeholder="BookID" name="bookid">
				<div class="searchtype">
					<input type="submit" name="return" value="Return">
				</div>
			</div>
        </form>
		<div class="tableheader">
			<h1>Checkout SEARCH</h1> 
		</div>
		<form action="result.php"
			  class="search-form"
			  method="post"
			  name="bookSearch">
			<div class="div-col">
				<div class="col1">
				<input maxlength="200"
					name="lookfor_co"
					size="40"
					title="Search Books"
					type="text"> by &nbsp;
				</div>
				<div class="searchtype">
					<select id="searchtype" name="type" size="1">
						<option value="title">Title</option>
						<option value="id">BookID</option>
						<option value="course">course</option>
					</select>
					<input name="start_over" type="hidden" value="1">
					<input type="submit" value="Search">
				</div>
			</div>
        </form>