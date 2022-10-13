import React, { Component } from 'react';
import TextField from '@mui/material/TextField';
import { w100 } from '../../style/defaultTheme';

class NameFilter extends Component {

  constructor(props) {
    super(props)

    this.state = {
      className: props.className,
      value: ''
    }
  }

  clearFilter() {
    this.setState({
      value: ''
    })
  }

  handleChange(evnt) {
    if (evnt.target.value === '') {
      this.props.deleteFilter('ItemName')
    } else {
      this.props.addFilter({ modsItemName: { str: 'itemName=' + evnt.target.value } })
    }
    this.setState({
      value: evnt.target.value
    })
  }

  render() {
    return (
      <div className={"nameFilter " + this.state.className} {...w100}>
        <TextField label="Item Name" variant="filled"
          onChange={evt => this.handleChange(evt)}
          value={this.state.value}
          sx={w100} />
      </div>
    );
  }
}

export default NameFilter;
