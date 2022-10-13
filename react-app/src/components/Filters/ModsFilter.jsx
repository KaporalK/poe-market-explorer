import React, { Component } from 'react';
import { makeApiCall } from '../../utils/ApiHelper';
import Autocomplete from '@mui/material/Autocomplete';
import TextField from '@mui/material/TextField';
import LabelxTxtField from '../Base/LabelxTxtField';
import Button from '@mui/material/Button';
import { css } from 'glamor';
import { flexBoxCenter, flexColumn, flexEnd, flexRow, w100 } from '../../style/defaultTheme';

class ModsFilter extends Component {

  constructor(props) {
    super(props)
    this.state = {
      provider: 'https://localhost/mods',
      addFilter: props.addFilter,
      deleteFilter: props.deleteFilter,
      className: props.className,
      modFilters: {},
      result: [],
      value: null
    }
  }

  componentDidMount() {
    this.autocomple('');
  }

  componentDidUpdate(prevProps){
    if(prevProps.filters !== this.props.filters){
      this.addModFilter(this.props.filters)
    }
  }

  autocomple(data) {
    this.setState({
      result: [],
      loading: true
    })
    const result = makeApiCall(this.state.provider + '?text=' + data, 1);
    result.then((e) => {
      this.setState({
        result: e['hydra:member'],
        loading: false
      })
    })
  }

  handleChange(newValue) {
    this.addModFilter(newValue)
  }

  addModFilter(mod) {
    this.setState(prevState => ({
      modFilters: { ...prevState.modFilters, [mod.slug]: mod.text }
    }))
  }

  deleteFilter(mod) {
    let modFiltersState = {}
    Object.assign(modFiltersState, this.state.modFilters)
    delete modFiltersState[mod[0]]
    this.setState({
      modFilters: { ...modFiltersState }
    })
    this.state.deleteFilter(mod[0])
  }

  clearFilter() {
    this.setState({
      modFilters: {}
    })
  }

  handleChangeMod(evnt, inputSlug) {
    console.log({value: evnt.target.value, inputSlug})
    const key = 'mods' + inputSlug;
    const stateName = 'value' + inputSlug;
    this.state.addFilter({
      [key]: { str: 'mods[' + inputSlug + ']=' + evnt.target.value }
    })
    this.setState({
      [stateName]: evnt.target.value
    })
  }

  render() {
    return (
      <div className={"modsFilter " + this.state.className} {...css(flexBoxCenter, flexColumn)}>
        <Autocomplete
          id="mod-filter"
          sx={w100}
          filterOptions={x => x}
          options={this.state.result.map((e) => {
            return { label: e.text, id: e.slug, ...e }
          })}
          onChange={(evnt, newValue) => {
            this.handleChange(newValue);
          }}
          onInputChange={(evnt, newValue) => {
            this.autocomple(newValue)
          }}
          renderInput={(params) => <TextField {...params} label="Add Mod Filter" variant="filled" />}
          value={this.state.value}
        />
        <div className="modList" >
          {Object.entries(this.state.modFilters).map(
            (filter) =>
              <div className="modFilter" {...css(flexEnd, flexRow)}>
                <LabelxTxtField
                  title={filter[1]}
                  handleChange={this.handleChangeMod.bind(this)}
                  label="Min"
                  additionalParam={[filter[0]]}
                  value={this.state['value' + filter[0]]}
                  InputProps={{ style: { maxWidth: 75 } }}>
                </LabelxTxtField>
                <Button 
                  variant="outlined" 
                  onClick={() => this.deleteFilter(filter)}
                  style={{ 
                    minWidth: '15px',
                    minHeight: '15px',
                    maxHeight: '30px',
                    maxWidth: '15px',
                    alignSelf: 'center',
                    fontWeight: 'bold'}}>
                    X</Button>
              </div>
          )}
        </div>
      </div>
    );
  }
}

export default ModsFilter;
