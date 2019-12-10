import React from 'react';
import './App.css';

class App extends React.Component {
  	constructor(props) {
    	super(props);
    	this.state = {
    		currentToDoItem: null,
    		toDoList: []
    	}
    	this.toggleDone = this.toggleDone.bind(this);
    	this.setCurrentToDoItem = this.setCurrentToDoItem.bind(this);
    	this.saveCurrentToDoItem = this.saveCurrentToDoItem.bind(this);
  	}
  	render() {
  		return (
  			<div>
				<h1>To-Do List</h1>
				<input
					onChange = {this.setCurrentToDoItem}
				/>
				<button
					onClick = {this.saveCurrentToDoItem}
				>Save</button>
				<div>
					<p>To-Do Items:</p>
					<ul>
					{
						this.state.toDoList.map((item, i) => 
							<li 
					  			key = {i} 
					  			className = {`todo ${item[1] ? "done" : ""}`}
					  			data-index = {i}
					  			onClick = {this.toggleDone}
					  		>
					  			{item[0]}
					  		</li>
					  	)
					}
					</ul>
				</div>
  			</div>
  		);
  	}
  	setCurrentToDoItem(e) {
  		const toDoItem = e.target.value;
		this.setState({
			...this.state,
			currentToDoItem: [toDoItem, false]
		});
	}
	saveCurrentToDoItem() {
		if (this.state.currentToDoItem) {
			this.setState({
				...this.state,
				toDoList: [this.state.currentToDoItem, ...this.state.toDoList]
			});
		}
	}
	toggleDone(e) {
		const index = parseInt(e.currentTarget.dataset.index);
		this.setState(prev => ({
			...this.state,
		    toDoList: prev.toDoList.map((item, i) => i === index ? [item[0], item[1] === false] : item)
		}));
  	}
}

export default App;
