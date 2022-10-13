import React, { Component } from 'react';
import LabelxTxtField from '../Base/LabelxTxtField';
import {flexBoxCenter, flexRow, filterWidth} from '../../style/defaultTheme'
import { css } from 'glamor';

class DefPropsFilter extends Component {

  constructor(props) {
    super(props)
    this.state = {
      addFilter: props.addFilter,
      className: props.className,
      valueArmour: '',
      valueEvasionRating: '',
      valueWard: '',
      valueBlock: '',
      valueEnergyShield: '',
    }
  }

  handleChange(evnt, inputName) {
    const trimed = inputName.replace(' ', '');
    const key = 'defProps' + trimed;
    const stateName = 'value' + trimed.charAt(0).toUpperCase() + trimed.slice(1);
    this.state.addFilter({
      [key]: { str: 'property[' + inputName + ']=' + evnt.target.value }
    })
    this.setState({
      [stateName]: evnt.target.value
    })
  }

  clearFilter() {
    this.setState({
      valueArmour: '',
      valueEvasionRating: '',
      valueWard: '',
      valueBlock: '',
      valueEnergyShield: '',
    })
  }

  render() {
    return (
      <div className={"defPropsFilter " + this.state.className} {...css(flexBoxCenter, flexRow, filterWidth)}>
        <div className="filter">
          <LabelxTxtField title="Armour"
            handleChange={this.handleChange.bind(this)}
            label="Armour min"
            additionalParam={["Armour"]}
            value={this.state.valueArmour} >
          </LabelxTxtField>
          <LabelxTxtField title="Energy Shield"
            handleChange={this.handleChange.bind(this)}
            additionalParam={["Energy Shield"]}
            value={this.state.valueEnergyShield} >
          </LabelxTxtField>
          <LabelxTxtField title="Block"
            handleChange={this.handleChange.bind(this)}
            additionalParam={["Block"]}
            value={this.state.valueBlock} >
          </LabelxTxtField>
        </div>
        <div className="filter">
          <LabelxTxtField title="Evasion"
            handleChange={this.handleChange.bind(this)}
            additionalParam={["Evasion Rating"]}
            value={this.state.valueEvasionRating} >
          </LabelxTxtField>
          <LabelxTxtField title="Ward"
            handleChange={this.handleChange.bind(this)}
            additionalParam={["Ward"]}
            value={this.state.valueWard} >
          </LabelxTxtField>
        </div>
      </div>
    );
  }
}

export default DefPropsFilter;
