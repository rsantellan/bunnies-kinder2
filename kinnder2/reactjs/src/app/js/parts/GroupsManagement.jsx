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
			addEmail: '',
			searchEmail: '',
			message: '',
			listdata: {
				columns: [{'key': 'id', 'label': 'id'}, {'key': 'email', 'label': 'email'}, {'key': 'active', 'label': 'active'}],
				shownColumns: [{'key': 'id', 'label': 'id'}, {'key': 'email', 'label': 'email'}],
				hiddenColumns: ['id'],
				items: [],	
			},
		}

		this.submitAddSimpleUser = this.submitAddSimpleUser.bind(this);
		this.submitUserSearch = this.submitUserSearch.bind(this);
		this.changeStateSearchSimpleUser = this.changeStateSearchSimpleUser.bind(this);
		this.changeStateAddSimpleUser = this.changeStateAddSimpleUser.bind(this);
		this.goToStateZero = this.goToStateZero.bind(this);
		this.deleteAction = this.deleteAction.bind(this);
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

	goToStateZero(){
		this.setState({step: 0});
	}
	changeStateSearchSimpleUser(event){
		this.setState({searchEmail: event.target.value});
	}
	changeStateAddSimpleUser(event){
		this.setState({addEmail: event.target.value});
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
	submitAddSimpleUser(e){
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
            		sessionData['addEmail'] = '';
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
		var searchBox = <SearchUsers submitUserSearch={this.submitUserSearch} />
		switch(this.state.step){
			case 1:
				console.log(this.state.listdata);
				return (<div>
					{ searchBox }
					<button className="btn btn-info" type="button" onClick={this.goToStateZero}>Volver</button>
					<div className="row">
						<div className="table-responsive no-border">
							<SimpleTable data={this.state.listdata} deleteAction={this.deleteAction} />
						</div>
					</div>
					</div>);
				break;
			default:
			return (
				<section className="panel">
				    <div className="panel-heading">Usuarios</div>
				    <div className="panel-body">
				        <div id="new_user_container">
				        	<div className="message">{this.state.message}</div>
				            <form onSubmit={ this.submitAddSimpleUser } role="form">
				                <div className="form-group">
				                    <label for="user_email">Email</label>
				                    <input type="email" className="form-control" required="required" name="user_email" id="user_email" value={this.state.addEmail} onChange={this.changeStateAddSimpleUser}/>
				                </div>
				                <div className="form-group">
				                    <button className="btn btn-default" type="submit">Guardar</button>
				                </div>	
				            </form>
				        </div>
				        <a className="btn btn-info pull-right" href={downloadUrl}><i className="fa fa-cloud-download"></i></a>
				        { searchBox }
				    </div>
				</section>
				);
			break;
		}
		
	}
}


class SearchUsers extends React.Component{

	constructor(props){
		super(props);
		this.state = {
			searchEmail: '',
		}
		this.changeStateSearchSimpleUser = this.changeStateSearchSimpleUser.bind(this);
	}

	changeStateSearchSimpleUser(event){
		this.setState({searchEmail: event.target.value});
	}

    render() {
        var that = this;
        return (
            <div id="search_user_container">
	            <form onSubmit={ that.props.submitUserSearch } role="form">
	                <div className="form-group">
	                    <label for="user_search_email">Email</label>
	                    <input type="text" id="user_search_email" name="search" placeholder="Buscar por email" className="form-control" required="requiered" value={this.state.searchEmail} onChange={this.changeStateSearchSimpleUser}></input>
	                </div>
	                <div className="form-group">
	                    <button className="btn btn-info" type="submit">Buscar</button>
	                </div>	
	            </form>
	        </div>
        );
    }
}

export default GroupsManagement;