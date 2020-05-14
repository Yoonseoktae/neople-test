<div id="board-wrap">
	<div class="board-search-wrap">
		<div class="board-total">
			<span class="total">
				전체 : <span class="total_count">2745</span>
			</span>
			<span class="page">
				(<b>1</b> / 138 page)
			</span>
		</div>
		<div class="board-search">
			<form name="frm_searchs" action="?mCode=MN096" method="post">
				<input type="hidden" name="mCode" value="MN096">
				<input type="hidden" name="mcode" value="">
				<input type="hidden" name="mode" value="list">
				<input type="hidden" name="mgr_seq" value="4">


				<div class="bbs-item">
					<span class="sch-items">
						<label for="searchID" class="blind">검색항목 선택</label>
						<select name="searchID" id="searchID" title="검색항목을 선택하세요">
							<option value="title">제목</option>
							<option value="contents">내용</option>
							<option value="member_name">작성자</option>
						</select>
					</span>
					<span class="sch-pakag">
						<span class="sch-input">
							<label class="blind" for="input_srch">검색어를 입력하세요</label>
							<input class="text vtop2 imehangul" name="searchKeyword" value="" placeholder="검색어를 입력하세요" size="40" type="text" id="input_srch">
						</span>
						<button class="btn-srh" type="submit"><span>검색</span></button>
					</span>
				</div>
			</form>
		</div>
	</div>

	<div class="board-list-wrap">
		<table class="board-list-table">
			<colgroup>
				<col class="num">
				<col class="subject">
				<col class="writer">
				<col class="date">
				<col class="cnt">
			</colgroup>
			<thead>
				<tr>
					<th scope="col">번호</th>
					<th scope="col">제목</th>
					<th scope="col">작성자</th>
					<th scope="col">작성일자</th>
					<th scope="col">조회</th>
				</tr>
			</thead>
			<tbody id="board-list-tbody">
			</tbody>
		</table>
	</div>

	<!-- 페이징-->
	<div class="board-list-paging">
		<div class="pagelist">
			<span class="firstpage1" title="처음 페이지">
				<span>처음 페이지</span>
			</span>

		</div>
	</div>

</div>