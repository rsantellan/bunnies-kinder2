import React from 'react';
import $ from "jquery";
import _ from 'lodash';

class SimpleTable extends React.Component{

	constructor(props){
		super(props);
		this.state = {
			columns: [],
			shownColumns: [],
			hiddenColumns: [],
			items: [],
		};
		this.componentDidMount = this.componentDidMount.bind(this);
		this.hideColumn = this.hideColumn.bind(this);
	}

	componentDidMount(){

	}

	getShownColumns(columns, hiddenColumns){
		return _.xorBy(columns, hiddenColumns, 'key');
	}

	hideColumn(e){
		var el = e.target;
		var dataKey = el.getAttribute("data-key");
		var wasHidden = false;
		var hiddenColumns = this.state.hiddenColumns;
		var newHiddenColumns = [];
		_.forEach(hiddenColumns, function(value){
			if(value.key == dataKey){
				wasHidden = true;
			}else{
				newHiddenColumns.push(_.clone(value));
			}
		});
		if(!wasHidden){
			_.forEach(this.state.columns, function(value){
				if(value.key == dataKey){
				   newHiddenColumns.push(_.clone(value));
				}
			});
		}
		var sessionData = this.state;
		sessionData['shownColumns'] = this.getShownColumns(this.state.columns, newHiddenColumns);
		sessionData['hiddenColumns'] = newHiddenColumns;
		this.setState({data: sessionData});
	}

	render(){
		var hasActions = false;
		if(this.props.editAction !== undefined || this.props.deleteAction !== undefined ){
			hasActions = true;
		}
		return (
			<table className="table table-bordered table-striped mg-t datatable">
			  <SimpleTableHead data={this.props.data} hasActions={hasActions} />
			  <SimpleTableBody data={this.props.data} editAction={this.props.editAction} deleteAction={this.props.deleteAction} />
			  <SimpleTableFoot data={this.props.data} />
			</table>
		);
	}
}

class SimpleTableHiddenColumnsList extends React.Component{
	constructor(props){
		super(props);
		this.state = {
			show: false
		}
		this.showHideData = this.showHideData.bind(this);
	}
	showHideData(e) {
		e.preventDefault();
		if(this.state.show){
			this.setState({show: false});
		}else{
			this.setState({show: true});	
		}
	}

	render(){
		return null;
		/*
	    var that = this;
	    if (this.state.show){
			return(
		    	<div>
			    	<a href="javascript:void(0)" onClick={this.showHideData}>Hide</a>
			    	<div id="hidden-columns-container" className="hidden">
				        <ul>
				        {this.props.data.columns.map(function (column, i) {
				            return <SimpleTableHiddenColumnListElement key={i} column={column} onHide={that.props.onHide}/>;
				        })}
				        </ul>
			        </div>
		        </div>
		    );
	    }else{
			return(
		    	<div>
			    	<a href="javascript:void(0)" onClick={this.showHideData}>Show</a>
		        </div>
		    );
	    }
	    */
	}
}


class SimpleTableHead extends React.Component{
	
	render() {
		var that = this;
		var actionRow = null;
		if(this.props.hasActions){
			actionRow = <th>Acciones</th>;
		}
		var direction = 'asc';
		if(that.props.data.paginate !== undefined){
			direction = that.props.data.paginate.direction;
		}
		return (
			<thead>
				<tr>
				{this.props.data.shownColumns.map(function (column, i) {
					return <SimpleTableHeadCell key={i} column={column} direction={direction} onSort={that.props.onSort} />
				})}
				{actionRow}
				</tr>
			</thead>
		);
	}
}

class SimpleTableBody extends React.Component{
    render() {
        var that = this;

        return (
            <tbody>
            {this.props.data.items.map(function(item, i) {
                return <SimpleTableRow key={i} item={item} columns={that.props.data.shownColumns} editAction={that.props.editAction} deleteAction={that.props.deleteAction} />
            })}
            </tbody>
        );
    }
}

class SimpleTableFoot extends React.Component{
	render() {
	    return (
	        <tfoot>
	            <tr>
	                <td colSpan={this.props.data.shownColumns.length}>
	                </td>
	            </tr>
	        </tfoot>
	    );
	}
}


class SimpleTableHiddenColumnListElement extends React.Component{
	render() {
		return (
			<li>{this.props.column.label}<input type="checkbox" name="hide" value={this.props.column.key} data-key={this.props.column.key} onChange={this.props.onHide}/></li>
		);
	}
}

class SimpleTableHeadCell extends React.Component{
    render() {
        return (
            <th><a href="javascript:void(0)" data-column={this.props.column.key} data-direction={this.props.direction === "desc" ? "asc" : "desc"} role="button" tabIndex="0" onClick={this.props.onSort}>{this.props.column.label}</a></th>
        );
    }
}

class SimpleTableRow extends React.Component{
    render() {
        var that = this;
        var editAction = null;
        var deleteAction = null;
		if(this.props.editAction !== undefined){
			editAction = <SimpleTableButton onClick={this.props.editAction} disabled={false} text="Editar" idMeta={this.props.item.id}/>
		} 
		if(this.props.deleteAction !== undefined ){
			deleteAction = <SimpleTableButton onClick={this.props.deleteAction} disabled={false} text="Eliminar" idMeta={this.props.item.id} className="btn btn-danger"/>
		}
		var showData = null;
		if(editAction !== null || deleteAction !== null){
			showData = <td>{editAction}{deleteAction}</td>;
		}
        return (
            <tr>
            {this.props.columns.map(function (column, i) {
                return <SimpleTableCell key={i} column={column} value={that.props.item[column.key]} />
            })}
            {showData}
            </tr>
        );
    }
}

class SimpleTableCell extends React.Component{
	_draw(column, value) {
        switch (column.type) {
            case 'Number':
                return value;
                break;
            case 'String':
                return value;
                break;
            case 'Image':
                return React.createElement('img', {src: value}, null);
                break;
            default:
                return value;
                break;
        }
    }
    render() {
        return (
            <td>{this._draw(this.props.column, this.props.value)}</td>
        );
    }
}

class SimpleTableButton extends React.Component{
    render() {
        return (
            <button type="button" onClick={this.props.onClick} disabled={this.props.disabled} data-id={this.props.idMeta} className={this.props.className}>{this.props.text}</button>
        );
    }
}

class AjaxTableOption extends React.Component{
    render() {
        return (
            <option value={this.props.value}>{this.props.value}</option>
        );
    }
}

export default SimpleTable;
