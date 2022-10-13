import React, { Component } from 'react';
import CategoryFilter from './CategoryFilter';
import NameFilter from './NameFilter';
import RarityFilter from './RarityFilter';
import SocketFilter from './SocketFilter';
import DefPropsFilter from './DefPropsFilter';
import ModsFilter from './ModsFilter';
import Button from '@mui/material/Button';
import { childButtonMargin, childFilterMargin, filterWidth, flexBoxCenter, flexColumn } from '../../style/defaultTheme'
import { css } from 'glamor';
import AtkPropsFilter from './AtkPropsFilter';

class FiltersList extends Component {

  constructor(props) {
    super(props)

    this.state = {
      NameFilterRef: React.createRef(),
      CategoryFilterRef: React.createRef(),
      RarityFilterRef: React.createRef(),
      SocketFilterRef: React.createRef(),
      DefPropsFilterRef: React.createRef(),
      ModsFilterRef: React.createRef(),
      modFilters: props.modFilters ?? {},
    }
  }

  addModFilter(mod) {
    let modUpdate = {}
    Object.assign(modUpdate, mod, { text: mod.search })
    this.state.ModsFilterRef.current.addModFilter(modUpdate);
  }

  clearFilter() {
    this.props.clearFilter();
    this.state.CategoryFilterRef.current.clearFilter();
    this.state.NameFilterRef.current.clearFilter();
    this.state.RarityFilterRef.current.clearFilter();
    this.state.SocketFilterRef.current.clearFilter();
    this.state.DefPropsFilterRef.current.clearFilter();
    this.state.ModsFilterRef.current.clearFilter();
  }

  confirmSearch() {
    this.props.valueConfirm(this.state.filters)
  }

  render() {
    return (
      <div className="search" {...css(filterWidth, flexBoxCenter, flexColumn, childFilterMargin, childButtonMargin)}>
        <NameFilter addFilter={this.props.addFilter}
          deleteFilter={this.props.deleteFilter}
          className="filter" ref={this.state.NameFilterRef} >
        </NameFilter>
        <CategoryFilter addFilter={this.props.addFilter}
          deleteFilter={this.props.deleteFilter}
          className="filter" ref={this.state.CategoryFilterRef} >
        </CategoryFilter>
        <RarityFilter addFilter={this.props.addFilter}
          deleteFilter={this.props.deleteFilter}
          className="filter" ref={this.state.RarityFilterRef} >
        </RarityFilter>
        <SocketFilter addFilter={this.props.addFilter}
          deleteFilter={this.props.deleteFilter}
          className="filter" ref={this.state.SocketFilterRef} >
        </SocketFilter>
        <AtkPropsFilter addFilter={this.props.addFilter}
          deleteFilter={this.props.deleteFilter}
          className="filter" ref={this.state.DefPropsFilterRef} >
        </AtkPropsFilter>
        <DefPropsFilter addFilter={this.props.addFilter}
          deleteFilter={this.props.deleteFilter}
          className="filter" ref={this.state.DefPropsFilterRef} >
        </DefPropsFilter>
        <ModsFilter addFilter={this.props.addFilter}
          deleteFilter={this.props.deleteFilter}
          className="filter"
          ref={this.state.ModsFilterRef}
          filters={this.state.modFilters} >
        </ModsFilter>
        <Button className="button" variant="outlined" onClick={() => this.clearFilter()} >clear filters</Button>
      </div>
    );
  }
}

export default FiltersList;