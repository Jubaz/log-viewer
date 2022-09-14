<template>
  <div class="input-group mb-3">
    <input v-model="this.logPath" type="text" class="form-control"
           placeholder="Full log path like '/var/log/system.log'"
           aria-label="Full log path" aria-describedby="button-addon2">
    <button @click="resetOffset()" class="btn btn-outline-secondary " type="button" id="button-addon2">View</button>
  </div>
  <table class="table">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Content</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="(log, index) in logs">
      <th scope="row">{{ index }}</th>
      <td>{{ log }}</td>
    </tr>
    </tbody>
  </table>

  <nav aria-label="Page navigation example">
    <ul class="pagination items-center">
      <li class="page-item">
        <a class="page-link" @click="resetOffset()" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
          <span class="sr-only"></span>
        </a>
      </li>
      <li class="page-item"><a class="page-link" @click="changeOffset(-10)"> &lt; </a></li>
      <li class="page-item"><a class="page-link" @click="changeOffset(10)"> &gt; </a></li>
      <li class="page-item">
        <a class="page-link" @click="fetchEndOfLog()" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
          <span class="sr-only"></span>
        </a>
      </li>
    </ul>
  </nav>
</template>


<script>
export default {
  name: 'LogsIndex',
  data: function () {
    return {
      'logs': [],
      'logPath': "",
      'offset': 0,
    }
  },
  created() {
  },
  computed: {},
  methods: {
    fetchLogs() {
      if (this.offset < 0) {
        this.offset = 0;
      }
      axios.get(route('api.logs.index', {
        offset: this.offset,
        logPath: this.logPath
      })).then(response => {
        if(response.data.data.length === 0){
          this.fetchEndOfLog();
          return;
        }
        this.logs = response.data.data;
      }).catch(error => {
        console.log(error)
        alert(error.response.data.message);
      });
    },
    changeOffset(offset) {
      this.offset = this.offset + offset;
      this.fetchLogs();
    },
    resetOffset() {
      this.offset = 0;
      this.fetchLogs();
    },
    fetchEndOfLog() {
      axios.get(route('api.log.lines.count', {
        logPath: this.logPath
      })).then(response => {
        this.offset = response.data.data.count - 10;
        this.fetchLogs()
      }).catch(error => {
        console.log(error)
        alert(error.response.data.message);
      });
    }
  }
}
</script>



