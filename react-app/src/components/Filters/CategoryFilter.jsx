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
      value: null
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

  handleChange(newValue) {
    if (newValue === null) {
      this.props.deleteFilter('Extendedategory')
    } else {
      this.state.addFilter({
        modsExtendedategory: {
          str: `extended.category=${newValue}`
        }
      })
    }
    this.setState({
      value: newValue
    })
  }

  clearFilter() {
    this.setState({
      value: null
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
          onChange={(evnt, newValue) => {
            this.handleChange(newValue);
          }}
          onInputChange={(evnt, newValue) => {
            this.autocomple(newValue)
          }}
          renderInput={(params) => <TextField {...params} label="Item Category" variant="filled" />}
          value={this.state.value}
        />
      </div>
    );
  }
}

export default CategoryFilter;
