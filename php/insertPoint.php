<div><h1 class="modal-header">Insert Point</h1></div>
				<div class="form-horizontal">
					<div class="span3" style="height:20px;float:left">
						<div class="control-group">
							<label class="control-label" for="nama">Name :</label>
							<div class="controls">
								<div id='jqxWidget' name="nama"></div>
								<div style="font-size: 13px; font-family: Verdana;" id="selectionlog"></div>
							</div>	
						</div>
						
						<div id="infoButton" class="control-group">
							<div class="controls">
								<button id="submit"  class="btn btn-primary"  href="javascript:void(0);" onclick="getInfo();">Search</button>
							</div>
						</div>
						
					</div>
					<div class="span4">
						<span class="infoDiv">
							<div class="control-group">
								<label class="control-label" for="nik">NIK :</label>
								<div class="controls">
									<input id="nik" class="input-large" name="nik" type="text" disabled />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="remarks">Remarks :</label>
								<div class="controls">
									<textarea id="remarks" name="remarks" ></textarea>
								</div>	
							</div>
							<div class="control-group">
								<label class="control-label" for="point">Point to Insert :</label>
								<div class="controls">
									<input id="point" class="input-mini" name="point" type="text" />
								</div>
							</div>
							<div id="submitButton" class="control-group">
							<div class="controls">
								<button id="submit"  class="btn btn-primary"  href="javascript:void(0);">Submit</button>
							</div>
						</div>
						</span>
					</div>
					<div class="span3">
						<span class="infoDiv">
							<div class="control-group">
								<label class="control-label" for="seksi">Section :</label>
								<div class="controls">
									<input id="seksi" class="input-large" name="seksi" type="text" disabled />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="level">Level :</label>
								<div class="controls">
									<input id="level" class="input-mini" name="level" type="text" disabled />
								</div>
							</div>
						</span>
					</div>
				</div>