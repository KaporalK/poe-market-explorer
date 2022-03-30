import React, { Component } from 'react';
import { makeApiCall } from '../../utils/ApiHelper';
import Autocomplete from '@mui/material/Autocomplete';
import TextField from '@mui/material/TextField';

class CategoryFilter extends Component {

  constructor(props) {
    super(props)
    this.state = {
      provider: 'https://localhost/properties?tag=Category',
      addFilter: props.addFilter,
      className: props.className,
      result: [],
    }
  }

  componentDidMount() {
    this.autocomple('');
  }


  autocomple(data) {
    this.setState({
      result: [],
      loading: true
    })
    const result = makeApiCall(this.state.provider + '&name=' + data, 1);
    result.then((e) => {
      this.setState({
        result: e['hydra:member'],
        loading: false
      })
    })
  }

  selectFilter(newValue) {
    console.log(newValue);
    this.state.addFilter({
      extendedategory: {
        str: `extended.category=${newValue}`
      }
    })
  }

  render() {
    return (
      <div className={"categoryFilter " + this.state.className}>
        <Autocomplete
          id="category-filter"
          filterOptions={x => x}
          options={this.state.result.map((e) => {
            return e.name
          })}
          onChange={(evet, newValue) => {
            this.selectFilter(newValue);
          }}
          onInputChange={(evt, newValue) => {
            this.autocomple(newValue)
          }}
          renderInput={(params) => <TextField {...params} label="Item Category" />}
        />
      </div>
    );
  }
}

export default CategoryFilter;
