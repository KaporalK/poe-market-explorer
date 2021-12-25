import React, { Component } from 'react';
import { makeApiCall } from '../../utils/ApiHelper';

class CategoryFilter extends Component {

  constructor(props) {
    super(props)
    this.state = {
      provider: 'https://localhost/properties?page=1&tag=Category',
      result: []
    }
  }

  autocomple(data){
      const result = makeApiCall(this.state.provider + '&name=' + data);
      this.setState({
        result: [],
        loading: true
      })
      result.then((e) => {
        this.setState({
            result: e['hydra:member'],
            loading: false
        })
      })
  }

  render() {
    return (
      <div className="CategoryFilter">
        <input type="text" onInput={evt => this.autocomple(evt.target.value)}></input>
        {this.state.loading ? '°' : ''}
        {this.state.result.length > 0 ? 
          <div>
            {this.state.result.map((e) => {
              console.log(e);
              return <p>{e.name}</p>
            })}
          </div>
        : ''}
      </div>
    );
  }
}

export default CategoryFilter;
