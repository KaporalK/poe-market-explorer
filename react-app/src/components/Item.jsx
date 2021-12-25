import React, { Component } from 'react';

class Item extends Component {

  constructor(props) {
    super(props)
    this.state = {
      item: props.item
    }
  }

  render() {
    return (
      <div className="Item">
        <h4>{this.state.item.baseType} {this.state.item.name}</h4>
        <p>Item level: {this.state.item.ilvl}</p>
      </div>
    );
  }
}

export default Item;
