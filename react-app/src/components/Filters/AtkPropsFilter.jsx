import React, { Component } from 'react';
import LabelxTxtField from '../Base/LabelxTxtField';
import { flexBoxCenter, flexRow, filterWidth } from '../../style/defaultTheme'
import { css } from 'glamor';

class AtkPropsFilter extends Component {

  constructor(props) {
    super(props)
    this.state = {
      addFilter: props.addFilter,
      className: props.className,
      valueDamage: '',
      valueCriticalStrikeChance: '',
      valuePhysicalDamage: '',
      valueDamagePS: '',
      valueAttacksperSecond: '',
      valueElementalDamage: '',
    }
  }

  handleChange(evnt, inputName) {
    const trimed = inputName.replace(/ /g, '');
    const key = 'atkProps' + trimed;
    const stateName = 'value' + trimed.charAt(0).toUpperCase() + trimed.slice(1);
    this.state.addFilter({
      [key]: { str: 'property[' + encodeURIComponent(inputName) + ']=' + evnt.target.value }
    })
    this.setState({
      [stateName]: evnt.target.value
    })
  }

  clearFilter() {
    this.setState({
      valueDamage: '',
      valueCriticalStrikeChance: '',
      valuePhysicalDamage: '',
      valueDamagePS: '',
      valueAttacksperSecond: '',
      valueElementalDamage: '',
    })
  }

  render() {
    return (
      <div className={"defPropsFilter " + this.state.className} {...css(flexBoxCenter, flexRow, filterWidth)}>
        <div className="filter">
          <LabelxTxtField title="Damage"
            handleChange={this.handleChange.bind(this)}
            label="TODO BACK"
            additionalParam={["TODO"]}
            value={this.state.valueDamage} >
          </LabelxTxtField>
          <LabelxTxtField title="Critical chance"
            handleChange={this.handleChange.bind(this)}
            additionalParam={["Critical Strike Chance"]}
            value={this.state.valueCriticalStrikeChance} >
          </LabelxTxtField>
          <LabelxTxtField title="Physical DPS"
            handleChange={this.handleChange.bind(this)}
            additionalParam={["Physical Damage"]}
            value={this.state.valuePhysicalDamage} >
          </LabelxTxtField>
        </div>
        <div className="filter">
          <LabelxTxtField title="Damage per Second"
            handleChange={this.handleChange.bind(this)}
            label="TODO BACK"
            additionalParam={["TODO"]}
            value={this.state.valueDamagePS} >
          </LabelxTxtField>
          <LabelxTxtField title="Attacks per Second"
            handleChange={this.handleChange.bind(this)}
            additionalParam={["Attacks per Second"]}
            value={this.state.valueAttacksperSecond} >
          </LabelxTxtField>
          <LabelxTxtField title="Elemental DPS"
            handleChange={this.handleChange.bind(this)}
            additionalParam={["Elemental Damage"]}
            value={this.state.valueElementalDamage} >
          </LabelxTxtField>
        </div>
      </div>
    );
  }
}

export default AtkPropsFilter;
