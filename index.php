<?php
session_start();

if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
	header("location:/login/index.php");
}else if (isset($_SESSION["reg_login"]) && $_SESSION["reg_login"] === true) {
	header("location:register/reg/index.php");
}else if (isset($_SESSION["login_1"]) && $_SESSION["login_1"] === true) {
	header("location:getkey/index.php");
}else if(isset($_SESSION["getkey_reg_login"]) && $_SESSION["getkey_reg_login"] === true){
	header("location:getkey/index.php");
}

require 'api/baidu_map.php';
require 'api/db_conn.php';
require 'api/config.php';
require 'api/request.php';

/* 移动端校验 start */
require 'check/check_moblie.php';
isMobile($mobile_url);
/* 移动端校验 end */

$register_check_error_log = false;

if(is_array($_GET)&&count($_GET)>0)//判断是否有Get参数
{
	if(isset($_GET["code"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false
	{
		$smscode = $_GET["code"];//存在
		$sql = "SELECT code_encryption FROM reg_check";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			// 输出数据
			while($row = $result->fetch_assoc()) {
				//判断数据库内是否有该code
				if($row["code_encryption"] == $smscode){

					$post_data = array('code' => $smscode);
					echo buildRequestForm('/register/index.php', $post_data, $method = 'post');
				}
			}
			$register_check_error_log = true;
		}
		
	}
	if(isset($_GET["login"]))
	{
	}
}
?>
<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="bookmark"href="/favicon.ico" />
		<title><?php echo $index_title; ?></title>
		<!-- Index css -->
		<link rel="stylesheet" href="css/style.css">
		<!-- Pop-up warning css -->
		<link rel="stylesheet" href="css/banneralert.css" />
		<!-- tip css -->
		<link rel="stylesheet" href="css/tip.css" />
		<!-- code css -->
		<link rel="stylesheet" href="css/code_animated.css" />
		<!-- font css -->
		<link rel="stylesheet" href="css/font.css">
		<!-- JQUERY -->
		<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>
		<!-- tip js -->
		<script src="js/tip/justToolsTip.js"></script>
		<!-- Hacker rain effect js -->
		<script src="js/typed.js" type="text/javascript"></script>
		<!-- Hacker rain effect -->
		<script type="text/javascript">
		$(function(){
			$("#typed").typed({
				// strings: ["Typed.js is a <strong>jQuery</strong> plugin.", "It <em>types</em> out sentences.", "And then deletes them.", "Try it out!"],
				stringsElement: $('#typed-strings'),
				typeSpeed: 100,
				backDelay: 500,
				loop: false,
				contentType: 'html', // or text
				// defaults to false for infinite loop
				loopCount: false,
				resetCallback: function() { newTyped(); }
			});

			$(".reset").click(function(){
				$("#typed").typed('reset');
			});

		});
		
		function web_tip(tipTitle, tipMessage,soundData){
			/* 网站提示 start */
			$(document).ready(function(){
				$("body").showbanner({
					title : tipTitle,
					content : tipMessage,
					sound : soundData,
					handle : false,
					show_duration : 200,
					duration : 2000,
					hide_duration : 700
				});
			});
			/* 网站提示 end */
		}
		</script>
		<!-- console show -->
		<script src="js/console_show.js"></script>
	</head>
	<!-- body element for prohibited mouse right click -->
	<body ondragstart="return false" oncontextmenu="return false" onselectstart="return false">
		<canvas id="canvas" width="1280" height="1024"> 你的浏览器不支持canvas标签，请您更换浏览器 </canvas>
		<script src="js/wordEffect.js"></script>
		
		<!-- Front end log show start -->
		<script src="js/log/screenlog.min.js"></script>
		<script>
		screenLog.init();
		screenLog.log('控制台日志终端');
		
		function website_version() {
			console.log('网站版本 v1.0');
		}
		function current_page() {
			console.log('当前页面 index.php');
		}
		/*
		function visite_count() {
			console.log('你是第 ' + "1" + " 位访客");
		}
		*/
		function ip() {
			console.log('IP地址 ' + '<?php echo getip(); ?>');
		}
		function address() {
			console.log('所在地 ' + '<?php getaddress(getip()); ?>');
		}
		function showConsole(){
			console.log('控制台准备就绪');
			var consoleDiv = document.getElementById("console").style;
			consoleDiv.display = "block";
		}
		function CODE_ERROR(){
			console.log('ERROR：你传递的CODE无法注册');
		}
		setTimeout(website_version,600);
		setTimeout(current_page,1200);
		setTimeout(showConsole,1800);
		/*setTimeout(visite_count,2400);*/
		setTimeout(ip,2400);
		setTimeout(address,3000);
		</script>
		<!-- Front end log show end -->
		
		<!-- textEffect start -->
		<div class="textEffect">
			<h1 id="titleLogo"><img src="images/title-logo.png"/></h1>
			<div id="typed-strings">
				<?php
				for($x=0;$x<count($index_textEffect);$x++){
					echo $index_textEffect[$x];
				}
				?>
				<!--<p>欢迎来到hex3f</p>
				<p>如果你是第一次来到这个网站。</p>
				<p>请接着看完：</p>
				<p>你想知道这个网站是在干嘛的吗？</p>
				<p>首先请听hex3f的来历。</p>
				<p>hex的含义是十六进制，</p>
				<p>3F来源在于ASCII码表，</p>
				<p>你可以搜索ASCII表查看3F的对应符号。</p>
				<p>3F的对应符号是“？”，</p>
				<p>？、“问号”代表着未知，</p>
				<p>这也是这个网站的寓意。</p>
				<p>这个网站有注册入口，</p>
				<p>但是需要花费你一定的时间注册。</p>
				<p>该网站不会泄露你的隐私，</p>
				<p>请放心享用！</p>
				<p>控制台输入 <span style="color:red;">register();</span> 开始注册</p>-->
			</div>
			<span id="typed" style="white-space:pre;"></span>
		</div>
		<!-- textEffect end -->
		
		<div id="game"><!-- minesweeper game initializes here --></div>
		
		<div class="console" id="console">
			<span>Console</span>
			<input type="text" id="console_text" value="请输入命令" onFocus="if(value=='请输入命令') {value=''}" onBlur="if(value==''){value='请输入命令'}">
			<script src="js/index/handle_check.js" ></script>
		</div>
		<div class="beian"><span>闽ICP备</span><span class="ConfirmOpenBeian"><b> 17027048 - 4 </b>号</span></div>
		<script>
		<?php
			if($register_check_error_log){
				echo "web_tip('错误','该CODE无法注册！请注意大小写！','http://downsc.chinaz.net/Files/DownLoad/sound1/201908/11827.wav');";
				echo "setTimeout(CODE_ERROR,4200);";
			}
		?>
		$(".demoUp").mouseover(function(){
			var _this = $(this);
			_this.justToolsTip({
				animation:"moveInTop",
				width:"500px",
				contents:_this.text(),
				gravity:'top'
			});
		})

		$(".demoDown").mouseover(function(){
			var _this = $(this);
			_this.justToolsTip({
				animation:"moveInBottom",
				//width:"300px",
				contents:_this.text(),
				gravity:'bottom'
			});
		})
		
		$(".ConfirmOpenBeian").click(function(){
			var _this = $(this);
			var abc = _this.justToolsTip({
				animation:"moveInTop",
				contents:"访问备案资料？",
				gravity:'top',
				confirm:true,
				onYes:function(self){
					window.open(<?php echo "'".$filing_url."'"; ?>);
				},
				noNO:function(self){
					
				}
			})
		})
		</script>
		<!-- tip js -->
		<script src="js/banneralert/banneralert.min.js" language="javascript"></script>
		<!--<script src="js/banneralert/example.js" language="javascript"></script>-->
		<script>
		var minesweeper = {
			
			cellWidth:16, // pixel width of cell image in sprite - used to calculate minefield width
			levels: {
				one: {
					id: 1,
					rows: <?php echo $checkgame_rows; ?>,
					cols: <?php echo $checkgame_cols; ?>,
					mines: <?php echo $checkgame_mines; ?>
				}
			},
			minCustomRows:		1,
			minCustomCols:		7,
			maxCustomRows:		50,
			maxCustomCols:		50,
			defaultLevel:       'one',
			currentLevel:       null,
			numRows:            null, // number of visible rows
			numCols:            null, // number of visible columns
			numMines:           null,
			mineCount:          null,
			numCells:           null, // total number of visible cells
			numRowsActual:      null, // 2 more than visible rows to add extra invisible surrounding cell layer to 
			numColsActual:      null, //    board. This avoids the need to check for boundaries in recursive revealCell method
			target:             null, // target where game board goes into (defaults to body if none supplied in init())
			cells:              [], // array of cell objects
			safeCells:          [], // array of cells without mines
			mineCells:          [], // array of cells with mines
			flagStates:         [ 'covered', 'flag', 'question' ], // right click states for covered cells
			numFlagStates:      null,
			includeMarks:       true,
			madeFirstClick:     false,
			stopTimerID:        0, // used to cancel setTimeout used for timer
			timer:              0,
			gameInProgress:     false,
			won:				false,
			mouseDown:          false,
			gameInitialized:    false,
			customDialogOpen:   false,
			
			/* DOM elements */
			$windowWrapperOuter:    null,
			$resetButton:           null,
			$mineCountOnes:         null,
			$mineCountTens:         null,
			$mineCountHundreds:     null,
			$timerOnes:             null,
			$timerTens:             null,
			$timerHundreds:         null,
			$minefield:             null,
									
		//-----------------------------------

		init: function( targetID ) {
			var self = this;
			
			// set vars that are dependant on other object vars
			this.target = targetID ? '#' + targetID : 'body';
			this.numFlagStates = self.flagStates.length;
			
			
			//'<div id="high-score-dialog" class="window-wrapper-outer"><div class="window-wrapper-inner"><div class="window-container"><p><label>Name:</label><input type="text" id="high-score-name" /><input type="button" value="Submit" id="submit-high-score" /></p></div></div></div>'
			
			// DOM creation
			$(this.target).append('<div id="game-container"><div id="custom-level-dialog" class="window-wrapper-outer"><div class="window-wrapper-inner"><div class="window-container"><div id="minesweeper-custom-fields"><p><label>Height:</label><input type="text" id="minesweeper-custom-height" class="form-textbox"></p><p><label>Width:</label><input type="text" id="minesweeper-custom-width" class="form-textbox"></p><p><label>Mines:</label><input type="text" id="minesweeper-custom-mines" class="form-textbox"></p></div><div id="minesweeper-custom-buttons"><input type="button" value="OK" id="minesweeper-ok-btn" class="form-button" /><input type="button" value="Cancel" id="minesweeper-cancel-btn" class="form-button" /></div></div></div></div></div><div id="high-score-dialog" class="window-wrapper-outer"><div class="window-wrapper-inner"><div class="window-container"><div id="high-score-dialog-content"><h2>High score!</h2></p><p><label id="high-score-name-label">Name:</label><input type="text" id="high-score-name-textbox" class="form-textbox" maxlength="20" /></p><p id="submit-high-score-container"><input type="button" value="Submit High Score" id="submit-high-score" class="form-button" /></p></div></div></div></div><div id="window-wrapper-outer" class="window-wrapper-outer"><div class="window-wrapper-inner"><div class="window-container"><div id="minesweeper-board-wrapper"><div id="minesweeper-header-wrapper"><div id="minesweeper-header-container"><div id="minesweeper-header"><div id="mine-count" class="numbers"><div id="mine-count-hundreds" class="t0"></div><div id="mine-count-tens" class="t1"></div><div id="mine-count-ones" class="t0"></div></div><div id="minesweeper-reset-button" class="face-smile"></div><div id="timer" class="numbers"><div id="timer-hundreds" class="t0"></div><div id="timer-tens" class="t0"></div><div id="timer-ones" class="t0"></div></div></div></div></div><div id="minefield"></div></div></div></div></div>');

			// capture special DOM elements that will be used
			this.$windowWrapperOuter =  $('#window-wrapper-outer');
			this.$resetButton =         $('#minesweeper-reset-button');
			this.$mineCountOnes =       $('#mine-count-ones');
			this.$mineCountTens =       $('#mine-count-tens');
			this.$mineCountHundreds =   $('#mine-count-hundreds');
			this.$timerOnes =           $('#timer-ones');
			this.$timerTens =           $('#timer-tens');
			this.$timerHundreds =       $('#timer-hundreds');
			this.$minefield =           $('#minefield');
			
			var $customDialog =     $('#custom-level-dialog'),
				$customWidthTxt =   $('#minesweeper-custom-width'),
				$customHeightTxt =  $('#minesweeper-custom-height'),
				$customMinesTxt =   $('#minesweeper-custom-mines'),
				$customOKBtn =      $('#minesweeper-ok-btn'),
				$customCancelBtn =  $('#minesweeper-cancel-btn');
			

			// set field defaults
			$customHeightTxt.val( this.levels[ this.defaultLevel ].rows );
			$customWidthTxt.val( this.levels[ this.defaultLevel ].cols );
			$customMinesTxt.val( this.levels[ this.defaultLevel ].mines );
			
			$intChecks = $customWidthTxt.add( $customHeightTxt ).add( $customMinesTxt );
			$intChecks.bind('keyup', function() {
				if (!/^\d+$/.test( $(this).val() ) ) {
					$(this).val('');
				}
			});
			
			$customOKBtn.bind('click', function() {
				// set custom menu item to checked
				$('.game-level').removeClass('checked');
				$menuCustom.addClass('checked');
				
				// hide custom dialog
				$customDialog.hide();
				self.customDialogOpen = false;
				
				
				/* set new game based on field inputs */
				var rowsVal = +$customHeightTxt.val(),
					colsVal = +$customWidthTxt.val(),
					minesVal = +$customMinesTxt.val(),
					rows = rowsVal < self.minCustomRows ? self.minCustomRows : (rowsVal > self.maxCustomRows ? self.maxCustomRows : rowsVal),
					cols = colsVal < self.minCustomCols ? self.minCustomCols : (colsVal > self.maxCustomCols ? self.maxCustomCols : rowsVal),
					minMines = 1,
					maxMines = Math.floor( (rows * cols) * 2/3 ),
					mines = minesVal < minMines ? minMines : (minesVal > maxMines ? maxMines : minesVal);
					if (mines > 999) mines = 999;
					
				$customHeightTxt.val(rows);
				$customWidthTxt.val(cols);
				$customMinesTxt.val(mines);
				self.newGame( 'custom', rows, cols, mines );
			});
			
			$customCancelBtn.bind('click', function() {
				$customDialog.hide();
				self.customDialogOpen = false;
			});
			/* END custom dialog events */
			
			$('#submit-high-score').bind('click', function() {
				$(this).attr('disabled', true);
				self.submitHighScore();	
			});
			
			
			/* reset button actions */
			this.$resetButton.bind('mousedown', function(e) {
				this.mouseDown = true;
				
				if (e.which === 3) {
					return false;
				}
				
				$(this).attr('class', 'face-pressed');
			}).bind('mouseup', function(e) {
				this.mouseDown = false;
				
				sendSMS = "can_not_send";
				console.log("已重置验证");
				web_tip("提示","已重置验证","sounds/reset_Button.wav");
				
				if (e.which === 3) {
					return false;
				}
				
				$(this).attr('class', 'face-smile');
			}).bind('mouseout', function(e) {
				if ( this.mouseDown ) {
					$(this).attr('class', 'face-smile');
				}
			}).bind('click', function(e) {
				if (e.which === 3) {
					return false;
				}
				
				self.reset();
			});
			
			this.newGame( this.defaultLevel );
			
			this.gameInitialized = true;
		}, // end init()

		//-----------------------------------

		newGame: function( level, numRows, numCols, numMines, resetting ) {
			var resetting = resetting || false;
			
			// if game has initialized, must stop game before creating a new one
			if ( this.gameInitialized ) {
				this.stop();
			}
			
			// if we're only resetting, we don't need to perform all
			// the tasks we would for a new game.
			if ( resetting ) {
				var cell, 
					i,
					j;

				// reset cells    
				for ( i = 1; i <= this.numRows; i++ ) {
					for ( j = 1; j <= this.numCols; j++ ) {
						cell = this.cells[i][j];
						
						cell.$elem.attr('class', 'covered');
						cell.classUncovered = 'mines0';
						cell.hasMine = false;
						cell.numSurroundingMines = 0;
						cell.flagStateIndex = 0; // 0 = covered, 1 = flag, 2 = question
					}
				}
			} else { // new game (not resetting)
				
				if ( level == 'custom' ) {
					this.numRows =      numRows;
					this.numCols =      numCols;
					this.numMines =     numMines;
					this.mineCount =    numMines;
				} else {
					var levelObj =  this.levels[ level ];
					this.numRows =  levelObj.rows;
					this.numCols =  levelObj.cols;
					this.numMines = levelObj.mines;
				}

				this.numCells =         this.numRows * this.numCols;
				this.numRowsActual =    this.numRows + 2;
				this.numColsActual =    this.numCols + 2;
				
				this.currentLevel = level;

				// set board width based on number of rows and columns
				this.$windowWrapperOuter.css('width', this.cellWidth * this.numCols + 27); // additional pixels to account for borders
				
				// create 2d cells array
				this.cells = new Array(this.numRowsActual);
				
				for ( i = 0; i < this.numRowsActual; i++ ) {
					this.cells[i] = new Array(this.numColsActual);
				}
				
				// clear out minefield cell elems
				this.$minefield.html('');
				
				// create new cells, and for each cell create object with properties,
				// which includes reference to jquery dom object       
				for ( i = 0; i < this.numRowsActual; i++ ) {
					for ( j = 0; j < this.numColsActual; j++ ) {
						if ( !(i < 1 || i > this.numRows || j < 1 || j > this.numCols) ) {
							$elem = $(document.createElement('div'))
								.attr('class', 'covered');
							
							this.$minefield.append($elem);
						} else {
							$elem = null;
						}
						
						// fill cells array element
						this.cells[i][j] = {
							$elem: $elem,
							covered: false, // we initialize all to false and later set visible ones to true (during setting of click events)
							classUncovered: 'mines0',
							hasMine: false,
							numSurroundingMines: 0,
							flagStateIndex: 0 // 0 = covered, 1 = flag, 2 = question
						}
					}
				} // end for (outer)
			} // end else new game
			
			
			
			this.setMineCount( this.numMines );
			
			this.setTimer( 0 );
			
			this.layMines();        
			
			// calculate and set number of surrounding mines for each cell
			this.calcMineCounts();
			
			this.setClickEvents();
			
			this.madeFirstClick = false;
			
			this.$resetButton.attr('class', 'face-smile');
		}, // end newGame()

		//-----------------------------------

		setClickEvents: function() {
			for ( i = 1; i <= this.numRows; i++ ) {
				for ( j = 1; j <= this.numCols; j++ ) {
					var self = this,
						cell = self.cells[i][j];
					
					// use this opportunity to set all visible cells to covered
					cell.covered = true;
					
					// hmmm....see http://stackoverflow.com/questions/1485770/how-to-store-local-variables-in-jquery-click-functions
					cell.$elem.bind('mousedown', {_i: i, _j: j, _cell: cell}, function(e) {
						self.mouseDown = true;
						
						var d       = e.data,
							_cell   = d._cell;
						
						// only do something if cell is covered
						if ( _cell.covered ) {
							// right mousedown
							if (e.which === 3) {
								// if this was a flag, means flag will be removed, so increment mine count
								if (_cell.flagStateIndex == 1) {
									self.setMineCount( self.mineCount + 1 );
								}
								
								// cycle flagStateIndex
								_cell.flagStateIndex = (_cell.flagStateIndex + 1) % self.numFlagStates;
								
								// if this becomes a flag, means flag added, so decrement mine count 
								if (_cell.flagStateIndex == 1) {
									self.setMineCount( self.mineCount - 1 );
								}
								
								// set new cell class
								_cell.$elem.attr('class', self.flagStates[ (_cell.flagStateIndex) ]);
							} else {
								// left mousedown
								
								if ( _cell.covered && _cell.flagStateIndex !== 1) {
									self.$resetButton.attr('class', 'face-surprised');
									_cell.$elem.attr('class', 'mines0');
								}
							} // end left mousedown
						} // end if covered
					}).bind('mouseover', {_cell: cell}, function(e) {
						if (self.mouseDown) {
							var _cell = e.data._cell;
							_cell.$elem.mousedown();
						}
					}).bind('mouseout', {_cell: cell}, function(e) {
						if (self.mouseDown) {
							var _cell = e.data._cell;                        
							if (_cell.covered) _cell.$elem.attr('class', 'covered');
						}
					}).bind('mouseup', {_i: i, _j: j, _cell: cell}, function(e) {
						self.mouseDown = false;
						
						var d       = e.data,
							_i      = d._i,
							_j      = d._j,
							_cell   = d._cell;
							
						self.$resetButton.attr('class', 'face-smile');
						
						// only do something if cell is still covered and not flagged
						if ( _cell.covered && _cell.flagStateIndex !== 1 ) {
							// left mouse click
							if (e.which !== 3) {
								// on first click, make sure cell does not have a mine;
								if (!self.madeFirstClick) {
									self.madeFirstClick = true;
									self.start();
									
									// if cell has mine, move mine and update surrounding mines numbers
									if (_cell.hasMine) {
										self.moveMine( _i, _j );
									}
								} // end if first click
								
								// user clicks mine and loses
								if (_cell.hasMine) {
									_cell.classUncovered = 'mine-hit';
									self.lose();
								} else {
									self.revealCells( _i, _j );
									
									// check for win
									if ( self.checkForWin() ) {
										self.win();
									}  
								}
							} // end left mouse click
						} // end if cell.covered
					}); // end click event
				} // end for (inner)
			}  // end for (outer)
		}, // end setClickEvents()

		//-----------------------------------    

		layMines: function() {
			var rowCol,
				cell,
				i;
			
			// designate mine spots
			this.designateMineSpots();
			
			for ( i = 0; i < this.numMines; i++ ) {
				rowCol = this.numToRowCol( this.mineCells[i] );
				cell = this.cells[ rowCol[0] ][ rowCol[1] ];            
				cell.hasMine = true;
				cell.classUncovered = 'mine';
			}
		}, // end layMines()

		//-----------------------------------
			
		// designate unique random mine spots and store in this.mineCells
		designateMineSpots: function() {
			this.safeCells = [];
			this.mineCells = []
			
			var i,
				randIndex;

			i = this.numCells;
			while ( i-- ) {
				this.safeCells.push( i + 1 );
			}
			
			i = this.numMines;
			while ( i-- ) {
				randIndex = -~( Math.random() * this.safeCells.length ) - 1;
				this.mineCells.push( this.safeCells[randIndex] );
				this.safeCells.splice( randIndex, 1 ); // remove cell from array of safe cells
			}        
		}, // end designateMineSpots

		//-----------------------------------    

		// calculate and set surrounding mine count for a cell
		calcMineCount: function( row, col ) {
			var count = 0,
				cell = this.cells[row][col],
				i, 
				j;
			
			for (i = row - 1; i <= row + 1; i++) {
				for (j = col - 1; j <= col + 1; j++) {
					// applying to surrounding cells, but we skip actual cell
					if (i == row && j == col) { continue; }
					
					if (this.cells[i][j].hasMine) { count++; }
				}
			}
			
			cell.numSurroundingMines = count;
			
			if (!cell.hasMine) { 
				cell.classUncovered = 'mines' + count;
			}
		},

		//-----------------------------------

		// calculate and set surrounding mine count for each cell
		calcMineCounts: function() {
			for ( var i = 1; i <= this.numRows; i++ ) {
				for ( var j = 1; j <= this.numCols; j++ ) {
					this.calcMineCount( i, j );
				}
			}
		},

		//-----------------------------------

		changeMineCount: function( row, col, numToAdd ) {
			// leave 3rd argument empty to increment, pass in -1 to decrement
			var numToAdd = numToAdd || 1,
				cell = this.cells[row][col];
				newMineCount = cell.numSurroundingMines + numToAdd;
			
			cell.numSurroundingMines = newMineCount;
			
			if (!cell.hasMine) {
				cell.classUncovered = 'mines' + newMineCount;
			}
		},

		//-----------------------------------

		changeSurroundingMineCounts: function( row, col, numToAdd ) {
			for (i = row - 1; i <= row + 1; i++) {
				for (j = col - 1; j <= col + 1; j++) {
					// applying to surrounding cells, but we skip actual cell
					if (i == row && j == col) continue;
					
					this.changeMineCount( i, j, numToAdd );
				}
			}
		},

		//-----------------------------------

		// move mine from given cell (row, col)
		moveMine: function( row, col ) {
			var cell = this.cells[row][col],
				spot = this.rowColToNum( row, col );
			
			// remove mine from this cell
			cell.hasMine = false;
			cell.classUncovered = 'mines' + cell.numSurroundingMines;
			
			// remove spot from mineCells and add to safeCells
			this.mineCells.splice( $.inArray(spot, this.mineCells), 1 );
			this.safeCells.push( spot );
			
			// decrement surrounding mine count of this cell
			this.changeSurroundingMineCounts( row, col, -1 );
			
			/* place mine in another random safe cell */
			var newIndex    = -~( Math.random() * this.safeCells.length ) - 1,
				newSpot     = this.safeCells[newIndex],
				newRowCol   = this.numToRowCol( newSpot ),                                  
				newMineCell = this.cells[ newRowCol[0] ][ newRowCol[1] ];

			newMineCell.hasMine = true;
			newMineCell.classUncovered = 'mine';
			
			// remove new spot from safeCells and add to mineCells
			this.safeCells.splice( $.inArray(newSpot, this.safeCells), 1 );
			this.mineCells.push( newSpot );
			
			// increment surrounding mine count of new mine cell
			this.changeSurroundingMineCounts( newRowCol[0], newRowCol[1], 1 );
		},

		//-----------------------------------

		revealMines: function( won ) {
			var cell,
				rowCol,
				won = won || false;
				i,
				j;
			
			
			for ( i = 0; i < this.numMines; i++ ) {
				rowCol = this.numToRowCol( this.mineCells[i] );
				cell = this.cells[ rowCol[0] ][ rowCol[1] ];
				
				if ( won ) {
					// flag mine cell if not already flagged
					if ( cell.flagStateIndex !== 1 ) {
						cell.flagStateIndex = 1;
						cell.$elem.attr('class', 'flag');
					}
				} else {
					// if cell is flagged and there's no mine, mark as misflagged
					if ( cell.flagStateIndex === 1 && !cell.hasMine) {
						cell.$elem.attr('class', 'mine-misflagged');
					} else if ( cell.hasMine ) {
						cell.$elem.attr('class', cell.classUncovered);
					}
				}
			}
		},

		//-----------------------------------

		flagMines: function() {
			this.revealMines( true );
		},

		//-----------------------------------

		// recursive method
		revealCells: function( row, col ) {
			var cell = this.cells[row][col],
				testCell,
				i,
				j;
			
			// reveal cell
			cell.$elem.attr('class', cell.classUncovered);
			cell.covered = false;
			
			// recursion escape condition:
			// If surrounding mine count is greater than 0, don't recurse, just return.
			if (cell.numSurroundingMines > 0) {
				return;
			} else {
				/* if surrounding mine count is 0, recursively go through all 
					adjacent cells with mine count 0 and reveal surrounding cells */
				for (i = row - 1; i <= row + 1; i++) {
					for (j = col - 1; j <= col + 1; j++) {
						// applying to surrounding cells, but we skip actual cell
						if (i == row && j == col) continue;
						
						testCell = this.cells[i][j];
						
						// skip if already uncovered
						if (!testCell.covered) {
							continue;
						}
						
						this.revealCells( i, j );                    
					}
				} // end for (outer)
			} // end else
		},

		//-----------------------------------

		toggleMarks: function() {
			if ( this.includeMarks ) {
				// turn marks off
				this.includeMarks = false;
				this.flagStates.splice( this.flagStates.length - 1, 1 );
			} else {
				// turn marks on
				this.includeMarks = true;
				this.flagStates.push( 'question' );
			}
			
			this.numFlagStates = this.flagStates.length;
		},

		//-----------------------------------

		numToRowCol: function( num ) {
			return [ Math.ceil(num/this.numCols), (num % this.numCols) || this.numCols ];
		},

		//-----------------------------------

		rowColToNum: function( row, col ) {
			return (row - 1) * this.numRows + col;
		},

		//-----------------------------------

		start: function() {
			this.gameInProgress = true;
			this.setTimer( 1 ); // start at 1 second, not 0
			this.runTimer();
		},

		//-----------------------------------

		stop: function() {
			this.stopTimer();
			this.gameInProgress = false;
			
			// remove cell click events
			for ( var i = 1; i <= this.numRows; i++ ) {
				for ( var j = 1; j <= this.numCols; j++ ) {
					this.cells[i][j].$elem.unbind('click mouseup mousedown');
				}
			}
		},

		//-----------------------------------

		reset: function() {
			this.newGame( null, null, null, null, true );
		},

		//-----------------------------------

		setTimer: function( num, settingMineCount ) {
			var settingMineCount = settingMineCount || false,
				onesElem =      settingMineCount ? this.$mineCountOnes      : this.$timerOnes,
				tensElem =      settingMineCount ? this.$mineCountTens      : this.$timerTens,
				hundredsElem =  settingMineCount ? this.$mineCountHundreds  : this.$timerHundreds,
				ones = Math.abs( num % 10 ),
				tens = Math.abs( (num / 10) % 10 | 0 ),
				hundreds = num < 0 ? 'm' : ( (num / 100) % 10 | 0 );
			
			if ( settingMineCount ) {
				this.mineCount = num;
			} else {
				this.timer = num;
			}
			
			onesElem.attr('class', 't' + ones);
			tensElem.attr('class', 't' + tens);
			hundredsElem.attr('class', 't' + hundreds);
		},

		//-----------------------------------

		setMineCount: function( num ) {
			this.setTimer( num, true );
		},

		//-----------------------------------

		runTimer: function() {
			var self = this;
			
			this.stopTimerID = setTimeout(function() {
				if ( self.gameInProgress ) {
					// user loses if timer reaches 999
					if (self.timer > 998) {
						self.lose();
						return;
					}
					
					self.setTimer( ++self.timer );
					
					self.runTimer();
				}
			}, 1000);
		},

		//-----------------------------------

		stopTimer: function() {
			clearTimeout( this.stopTimerID );
		},

		//-----------------------------------

		lose: function() {
			this.stop();
			this.revealMines();
			this.$resetButton.attr('class', 'face-sad');
			console.log("验证失败");
			web_tip("错误","验证失败","http://downsc.chinaz.net/Files/DownLoad/sound1/201908/11827.wav");
		},

		//-----------------------------------

		checkForWin: function() {
			var openCells = 0;
			
			for ( var i = 1; i <= this.numRows; i++ ) {
				for ( var j = 1; j <= this.numCols; j++ ) {
					if ( !this.cells[i][j].covered ) openCells++;
				}
			}
			
			return openCells === this.numCells - this.numMines;
		},

		//-----------------------------------

		win: function() {
			this.won = true;
			this.stop();
			this.flagMines();
			this.$resetButton.attr('class', 'face-sunglasses');
			//扫雷成功
			sendSMS = "20d1d47b8ac2d9635d2bdf7ec4f17c302bcd956c3dea4bb4aeca366d7e37709551ca509c220ff8495a1642489088d8c0a05e0df1723dbae40dc4da5c23595e33:nozuobi";
			console.log('验证成功 允许输入手机号');
			this.setMineCount( 0 );
			web_tip("提示","在控制台中输入手机号即可接受注册短信","sounds/tip_music.wav");
			var self = this,
			levelId = 1; //self.levels[self.currentLevel].id;
			
			// check if high score
			// $.get('minesweeper/ajax.minesweeper.php?t=' + (new Date()).getTime(), { checking: true, level_id: levelId, time: self.timer }, function( data ) {
			// 	// if ajax call returns a 'y' (yes), means it's a high score
			// 	if ( data == 'y' ) {
			// 		self.displayHighScoreDialog();	
			// 	}
			// });
		},

		//-----------------------------------

		displayHighScoreDialog: function() {
			$('#submit-high-score').attr('disabled', false);
			$('#high-score-dialog').show();
		},

		//-----------------------------------

		submitHighScore: function() {
			if (!this.won) {
				return;
			}
			
			var self = this,
				name = $('#high-score-name-textbox').val(),
				levelId = 1; //self.levels[self.currentLevel].id;			
		},

		};

		$(document).ready(function() {
			minesweeper.init('game');
		});
		</script>
	</body>
</html>
