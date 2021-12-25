import React, { Component } from 'react';

class Searchbar extends Component {

  constructor(props) {
    super(props)

    this.state = {
      change: props.change,
    }
  }

  render() {
    return (
      <div className="Searchbar">
        <h1>
          I am the Searchbar
        </h1>
        <input type="text" onChange={evt => this.state.change(evt.target.value)}></input>
      </div>
    );
  }
}

export default Searchbar;
