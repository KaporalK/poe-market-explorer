import React, { Component } from 'react';
import './NameFilter.css';

class NameFilter extends Component {

  constructor(props) {
    super(props)

    this.state = {
      addFilter: props.addFilter,
      className: props.className
    }
  }

  render() {
    return (
      <div className={"nameFilter " + this.state.className}>
        <p>
          Item name
        </p>
        <input type="text" onChange={evt => this.state.addFilter({ itemName: { str: 'itemName=' + evt.target.value } })}></input>
      </div>
    );
  }
}

export default NameFilter;
