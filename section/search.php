
		<div class="tableheader">
			<h1>BOOK SEARCH</h1> 
		</div>
		<form action="result.php"
			  class="search-form"
			  method="post"
			  name="bookSearch">
			<div class="div-col">
				<div class="col1">
				<input maxlength="200"
					name="lookfor"
					size="40"
					title="Search Books"
					type="text"> by &nbsp;
				</div>
				<div class="searchtype">
					<select id="searchtype" name="type" size="1">
						<option value="title">Title</option>
						<option value="isbn">ISBN</option>
						<option value="course">course</option>
						<option value="professor">professor</option>
					</select>
					<input name="start_over" type="hidden" value="1">
					<input type="submit" value="Search">
				</div>
			</div>
        </form>
