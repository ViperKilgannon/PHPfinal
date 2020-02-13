<template>
  <v-app id="keep">
    <v-app-bar app clipped-left color="blue">
      <span class="title ml-3 mr-5">
        Dino&nbsp;
        <span class="font-weight-light">Admin</span>
      </span>
      <v-text-field
        solo-inverted
        flat
        hide-details
        label="Search"
        prepend-inner-icon="mdi-magnify"
      />

      <v-spacer />
    </v-app-bar>

    <v-content class="grey darken-3 fill-height">
      <v-data-table
        :headers="headers"
        :items="UsersLoggedIn"
        :items-per-page="20"
        class="elevation-1 mx-12 grey lighten-1"
      >
        <template v-slot:item.dayPass="{ item }">
          <v-simple-checkbox v-model="item.dayPass"></v-simple-checkbox>
        </template>
        <template v-slot:item.equipment="{ item }">
          <v-simple-checkbox v-model="item.equipment"></v-simple-checkbox>
        </template>
      </v-data-table>
    </v-content>
  </v-app>
</template>

<script>
export default {
  props: {
    source: String
  },
  data: () => ({
    headers: [
      {
        text: "Current Users Logged In",
        align: "left",
        sortable: false,
        value: "name"
      },
      { text: "Pre-paid Hours", value: "Hours" },
      { text: "Time In", value: "todayIn" },
      { text: "Ammount Owed", value: "owedAmount" },
      { text: "Day Pass?", value: "dayPass" },
      { text: "Has Equipment?", value: "equipment" }
    ],
    UsersLoggedIn: [
      {
        name: "Bill Clinton",
        Hours: 5,
        todayIn: "10:56",
        owedAmount: "$20.00",
        dayPass: false,
        equipment: true
      },
      {
        name: "Bill Clinton",
        Hours: 5,
        todayIn: "10:56",
        owedAmount: "$20.00",
        dayPass: false,
        equipment: true
      },
      {
        name: "Bill Clinton",
        Hours: 5,
        todayIn: "10:56",
        owedAmount: "$20.00",
        dayPass: false,
        equipment: true
      },
      {
        name: "Bill Clinton",
        Hours: 5,
        todayIn: "10:56",
        owedAmount: "$20.00",
        dayPass: false,
        equipment: true
      },
      {
        name: "Bill Clinton",
        Hours: 5,
        todayIn: "10:56",
        owedAmount: "$20.00",
        dayPass: false,
        equipment: true
      },
      {
        name: "Bill Clinton",
        Hours: 5,
        todayIn: "10:56",
        owedAmount: "$20.00",
        dayPass: false,
        equipment: true
      },
      {
        name: "Bill Clinton",
        Hours: 5,
        todayIn: "10:56",
        owedAmount: "$20.00",
        dayPass: false,
        equipment: true
      }
    ]
  })
};
</script>

<style>
#keep .v-navigation-drawer__border {
  display: none;
}
</style>
