import React, { Component } from 'react';
import Item from './Item';

class ItemList extends Component {

  constructor(props) {
    super(props)
    this.state = {
      items: props.items,
      loading: false,
    }
  }

  updateItems(items){
    this.setState({
      items: items
    })
  }

  addItems(items){
    this.setState(prevState => ({
      items: [...prevState.items, ...items]
    }))
  }

  render() {
    return (
      <div className="ItemList">
        <h3> Iam the result</h3>
        <input 
          type='submit' value='clear list' 
          onClick={() => this.setState({items: [], loading: false})}
        ></input>
        {this.state.items.map((item, i) => {
          return <Item key={i} item={item}></Item>
        })}
        {this.state.loading ? <p>Loading</p> : ''}
      </div>
    );
  }
}

export default ItemList;
