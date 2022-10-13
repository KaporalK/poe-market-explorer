import React, { Component } from 'react';
import TextField from '@mui/material/TextField';
import { css } from 'glamor';
import { flexBoxCenter, placingStyle } from '../../style/defaultTheme';

const flexEnd = css({
  justifyContent: 'flex-end'
})

const childMargin = css({
  ' > *': {
    margin: '5px'
  }
})
class LabelxTxtField extends Component {

  constructor(props) {
    super(props)
    this.state = {
      title: props.title,
      handleChange: props.handleChange,
      additionalParam: props.additionalParam ?? [],
      value: props.value ?? '',
      label: props.label,
      InputProps: props.InputProps ?? {},
      InputLabelProps : props.InputProps  ?? {},
    }
  }

  //todo find opti ? dont know if update the state at every call is a good idea
  componentDidUpdate(prevProps){
    if(prevProps.value !== this.props.value){
      this.setState({
        value: this.props.value
      })
    }
    if(prevProps.title !== this.props.title){
      this.setState({
        title: this.props.title
      })
    }
    if(prevProps.label !== this.props.label){
      this.setState({
        label: this.props.label
      })
    }
    if(prevProps.additionalParam !== this.props.additionalParam){
      this.setState({
        additionalParam: this.props.additionalParam
      })
    }
  }

  render() {
    return (
      <div className="labelxTxtField" {...css(flexBoxCenter, flexEnd, placingStyle, childMargin)}>
        <label>{this.state.title}</label>
        <TextField label={this.state.label ?? this.state.title} variant="filled"
          onChange={evt => this.state.handleChange(evt, ...this.state.additionalParam)}
          value={this.state.value} 
          size="smal"
          InputProps={this.state.InputProps}
          InputLabelProps={this.state.InputLabelProps}/>
      </div>
    );
  }
}

export default LabelxTxtField;
