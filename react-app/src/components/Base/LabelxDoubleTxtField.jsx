import React, { Component } from 'react';
import './LabelxTxtField.css';
import TextField from '@mui/material/TextField';

class LabelxDoubleTxtField extends Component {

  constructor(props) {
    super(props)
    this.state = {
      title: props.title,
      handleChange: props.handleChange,
      additionalParam: props.additionalParam ?? [],
      value: props.value ?? '',
      label: props.label,
    }
  }

  componentDidUpdate(prevProps){
    if(prevProps.value !== this.props.value){
      this.setState({
        value: this.props.value
      })
    }
  }

  render() {
    return (
      <div className="labelxTxtField">
        <label>{this.state.title}</label>
        <TextField label={this.state.label ?? this.state.title} variant="filled"
          onChange={evt => this.state.handleChange(evt, ...this.state.additionalParam)}
          value={this.state.value} 
          size="smal"/>
      </div>
    );
  }
}

export default LabelxDoubleTxtField;
