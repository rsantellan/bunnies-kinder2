import React from 'react';
import $ from "jquery";
import _ from 'lodash';
import toastr from "toastr";

import SimpleTable from './../components/SimpleTable.jsx';

class GroupsManagement extends React.Component{

	constructor(props){
		super(props);
		this.state = {
			step: 0,
			groupName: '',
			editedGroupId: 0,
			searchEmail: '',
			message: '',
			listdata: {
				columns: [{'key': 'id', 'label': 'id'}, {'key': 'name', 'label': 'Nombre'}],
				shownColumns: [{'key': 'id', 'label': 'id'}, {'key': 'name', 'label': 'Nombre'}],
				hiddenColumns: [{'key': 'id', 'label': 'id'}],
				items: [],	
			},
		}

		this.componentDidMount = this.componentDidMount.bind(this);
		this.loadGroupsFromServer = this.loadGroupsFromServer.bind(this);
		this.submitAddSimpleUserGroup = this.submitAddSimpleUserGroup.bind(this);
		this.submitUserSearch = this.submitUserSearch.bind(this);
		this.changeStateSearchSimpleUser = this.changeStateSearchSimpleUser.bind(this);
		this.changeStateGroupName = this.changeStateGroupName.bind(this);
		this.goToStateZero = this.goToStateZero.bind(this);
		this.goToStateOne = this.goToStateOne.bind(this);
		this.goToStateTwo = this.goToStateTwo.bind(this);
		this.deleteAction = this.deleteAction.bind(this);
		this.editAction = this.editAction.bind(this);
	}

	componentDidMount() {
	    this.loadGroupsFromServer();
	    console.log('componentDidMount');
  	}

  	loadGroupsFromServer(){
  		console.log('loadGroupsFromServer');
  		var that = this;
  		$.ajax({
            url: $('#'+this.props.searchUrlId).val(),
            type: 'post',
            dataType: "json",
            success: function (data) {
            	var sessionData = that.state;
            	sessionData['listdata']['items'] = data;
				that.setState(sessionData);
            }.bind(this),
            error: function (xhr, status, err) {
                console.log(this.props.actionUrl, status, err.toString());
            }.bind(this)
        });
  	}

  	editAction(e){
		var el = e.target;
		var dataId = el.getAttribute("data-id");
		var that = this;
		var items = this.state.listdata.items;
		var object = _.clone(_.find(items, function(o){ return o.id == dataId }));
		if(object !== undefined){
			this.setState({groupName: object.name});
			this.setState({editedGroupId: dataId});
			this.goToStateTwo();	
		}else{
			alert('Objecto no encontrado!');
		}
		
  	}

	deleteAction(e){
		var el = e.target;
		var dataId = el.getAttribute("data-id");
		var that = this;
		$.ajax({
            url: $('#'+this.props.removeUrlId).val(),
            type: 'post',
            data: {'id' : dataId},
            dataType: "json",
            success: function (data) {
            	if(data.result == true){
            		toastr.info(data.message);
            		var sessionData = that.state;
            		_.remove(sessionData['listdata']['items'], function(element){
            			console.log(element);
            			return element.id == dataId;
            		});
    				that.setState(sessionData);
            	}else{
            		toastr.error(data.message);
            	}
            }.bind(this),
            error: function (xhr, status, err) {
                console.log(this.props.actionUrl, status, err.toString());
            }.bind(this)
        });
		e.preventDefault();
	}

	goToStateTwo(){
		console.log('step two');
		this.setState({step: 2});
	}

	goToStateOne(){
		console.log('step one');
		this.setState({step: 1});
	}

	goToStateZero(){
		this.setState({groupName: ''});
		this.setState({step: 0});
	}
	changeStateSearchSimpleUser(event){
		this.setState({searchEmail: event.target.value});
	}
	changeStateGroupName(event){
		this.setState({groupName: event.target.value});
	}

	submitUserSearch(e){
		var that = this;
		$.ajax({
            url: $('#'+this.props.searchUrlId).val(),
            type: 'post',
            data: $(e.target).serialize(),
            dataType: "json",
            success: function (data) {
            	console.log(data);
	        	var sessionData = that.state;
            	sessionData['step'] = 1;
            	sessionData['listdata']['items'] = data;
				that.setState(sessionData);
            }.bind(this),
            error: function (xhr, status, err) {
                console.log(this.props.actionUrl, status, err.toString());
            }.bind(this)
        });
		e.preventDefault();
	}
	submitAddSimpleUserGroup(e){
		var that = this;
		$.ajax({
            url: $('#'+this.props.addUrlId).val(),
            type: 'post',
            data: $(e.target).serialize(),
            dataType: "json",
            success: function (data) {
	        	var sessionData = that.state;
            	sessionData['message'] = data.message;
            	if(data.result == true){
            		sessionData['groupName'] = '';
            		var items = sessionData['listdata']['items'];
            		items.push(data.item);
            		sessionData['listdata']['items'] = items;
            	}
				that.setState(sessionData);
            }.bind(this),
            error: function (xhr, status, err) {
                console.log(this.props.actionUrl, status, err.toString());
            }.bind(this)
        });
		e.preventDefault();
	}

	render(){
		var downloadUrl = $('#'+this.props.downloadUrlId).val();
		console.log(this.state.step);
		switch(this.state.step){
			case 1:
				console.log(this.state.listdata);
				return (
					<section className="panel">
					    <div className="panel-heading">Grupos</div>
						    <div className="panel-body">
							<button className="btn btn-info" type="button" onClick={this.goToStateZero}>Crear</button>
							<div className="row">
								<div className="table-responsive no-border">
									<SimpleTable data={this.state.listdata} editAction={this.editAction} deleteAction={this.deleteAction} />
								</div>
							</div>
						</div>
					</section>);
				break;
			case 2:
				return (<AddEditUserGroup groupName={ this.state.groupName } buttonText="Editar" message={this.state.message} submitSendFunction={this.submitAddSimpleUserGroup} goToState={this.goToStateOne} />);
			break;
			default:
				return (<AddEditUserGroup groupName={ this.state.groupName } buttonText="Guardar" message={this.state.message} submitSendFunction={this.submitAddSimpleUserGroup} goToState={this.goToStateOne} />);
			break;
		}
		
	}
}

class AddEditUserGroup extends React.Component{

	constructor(props){
		super(props);
		this.state = {
			userGroupName: '',
		}
		this.changeStateGroupName = this.changeStateGroupName.bind(this);
	}

	changeStateGroupName(event){
		this.setState({userGroupName: event.target.value});
	}

	render(){
		return (
		<section className="panel">
		    <div className="panel-heading">Grupos</div>
		    <div className="panel-body">
		        <div id="new_user_container">
		        	<div className="message">{this.props.message}</div>
		            <form onSubmit={ this.props.submitSendFunction } role="form">
		                <div className="form-group">
		                    <label htmlFor="userGroupName">Nombre</label>
		                    <input type="text" className="form-control" required="required" name="userGroupName" id="userGroupName" value={this.props.groupName} onChange={this.changeStateGroupName}/>
		                </div>
		                <div className="form-group">
		                    <button className="btn btn-default" type="submit">{this.props.buttonText}</button>
		                </div>	
		            </form>
		        </div>
		        <button className="btn btn-info pull-right" type="button" onClick={this.props.goToState}>Listado</button>
		    </div>
		</section>
		);
	}
}

export default GroupsManagement;