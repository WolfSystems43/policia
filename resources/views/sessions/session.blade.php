@extends('layouts.material')

@section('title', 'En servicio')

@section('content')
   <br>
   <div id="app" class="container">
       <div v-if="! ended">
           <div class="card-panel">
               <div class="row">
                   <div class="col s8">
                   <span v-if="! gameSession.is_closed">
                       <h5><i class="material-icons left green-text">check_circle</i> Estás de servicio</h5>
                       <span>Turno de @{{ gameSession.name }}, @{{ gameSession.server.name }}</span>
                   </span>
                       <span v-if="gameSession.is_closed">
                       <h5><i class="material-icons left">alarm</i> Servicio a punto de terminar</h5>
                       <span>Turno de @{{ gameSession.name }}</span>
                   </span>
                   </div>
                   <div class="col m4">
                       <form action="{{ route('work-end') }}" method="POST">
                           {{csrf_field()}}
                           <button onclick="return confirm('¿Dejas el servicio?')" class="red btn waves-effect"><i class="material-icons left">exit_to_app</i> Dejar el servicio</button>
                       </form>
                   </div>
               </div>
           </div>
           <div class="row">
               <div class="col s12" v-if="loading">
                   <div class="progress">
                       <div class="indeterminate"></div>
                   </div>
               </div>
               <div class="col s12 l6">
                   <p>Frecuencias del servicio</p>
                   <div class="card-panel">
                       <table class="highlight">
                           <thead>
                           <tr>
                               <th data-field="id">{{ trans('messages.frequencies_name') }}</th>
                               <th data-field="name">{{ trans('messages.frequencies_frequency') }}</th>
                           </tr>
                           </thead>

                           <tbody>

                           <tr v-for="freq in gameSession.freq.content">
                               <td>@{{ freq[0] }}</td>
                               <td>
                                   <a onclick="Materialize.toast('Copiada al portapapeles', 4000)" title="Copiar" ref="#!" style="cursor: pointer;" class="freq-button freq-copy tooltipped" data-tooltip="Copiar frecuencia al portapapeles" :data-clipboard-text="freq[1]"> <i class="tiny left material-icons" style="padding-left: 8px">content_copy</i>
                                   </a>
                                   <span class="spoiler">@{{ freq[1]}}</span>
                               </td>
                           </tr>

                           </tbody>
                       </table>
                   </div>
               </div>
               <div class="col s12 l6">
                   <p>@{{ gameSession.works.length }} en el servicio</p>
                   <div class="card-panel">
                       <table class="highlight">
                           <thead>
                           <tr>
                               <th></th>
                               <th>Nombre</th>
                               <th></th>
                               <th>Entrada</th>
                               <th v-if="mando"></th>
                           </tr>
                           </thead>
                           <tbody>
                           <tr v-for="work in orderedWorks">
                               <td>
                                   <center>
                                       <img :src="work.user.rank_image" height="24" class="list-img tooltipped" :data-tooltip="work.user.rank_name">
                                       <img :src="work.user.corp_image" height="24" class="list-img tooltipped" :data-tooltip="work.user.corp_name">
                                   </center>
                               </td>
                               <td>@{{ work.user.name }}</td>
                               <td>
                                   <span style="padding-right: 8px" v-for="specialty in work.user.visible_specialties">
                                       <specialty-img :id="specialty.id" :acronym="specialty.acronym"></specialty-img>
                                   </span>
                               </td>
                               <td>@{{ moment(work.created_at).format('H:mm') }}</td>
                               <td v-if="mando"><i class="material-icons tiny red-text tooltipped" data-tooltip="MANDO: Echar del servicio" @click="kick(work)">remove_circle_outline</i></td>
                           </tr>
                           </tbody>
                       </table>
                   </div>
               </div>

               <div class="col l6 s12" v-if="false">
                   <p>Situaciones posibles según agentes de servicio</p>
                   <div class="card-panel">
                       <ul>
                           <li v-if="gameSession.works.length >= 6">Secuestrar policías</li>
                           <li v-if="gameSession.works.length >= 6">Robar vehículos policiales</li>
                           <li v-if="gameSession.works.length >= 8">Robo al banco</li>
                           <li v-if="gameSession.works.length >= 8">Atraco a la Joyería</li>
                           <li v-if="gameSession.works.length >= 8">Asalto a la casa del alcalde</li>
                           <li v-if="gameSession.works.length >= 8">Asalto a la Central Nuclear</li>
                           <li v-if="gameSession.works.length >= 5">Robo a la sucursal[ del banco</li>
                           <li v-if="gameSession.works.length >= 3">Robos a gasolineras</li>
                       </ul>
                   </div>
               </div>
           </div>
           <small class="right">@{{ load.fromNow() }}</small>
       </div>
       <div v-if="ended">
           <div class="card-panel">
               <h5>Fin del servicio</h5>
               <p>Este servicio ha finalizado hace unos segundos. Muchas gracias por tu trabajo.</p>
               <a href="{{ route('start-work') }}" class="btn blue waves-effect"><i class="material-icons left">list</i> Ver otros servicios disponibles</a>
           </div>
       </div>
   </div>
@endsection


@section('footer')
    <script src="https://cdn.jsdelivr.net/lodash/4.17.4/lodash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.0/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/clipboard.js/1.6.0/clipboard.min.js"></script>
    <script>
        new Clipboard('.freq-copy');
        Vue.config.devtools = true;
        // Vue for this page
        moment.locale('es');
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // components
        Vue.component('specialty-img', {
            props: ['id', 'acronym'],
            template: '<a :href="url"><img :src="imageUrl" height="24" class="tooltipped" :data-tooltip="this.acronym"></a>',
            computed: {
                url: function () {
                    return '/especializacion/' + this.id;
                },
                imageUrl: function () {
                    return '/img/divisas/especialidades/' + this.id + '.png';
                }
            }
        });

        // vue
        var vm = new Vue({
            el: '#app',
            data: {
                gameSession: JSON.parse('{!! Auth::user()->getWork()->gameSession->load(['server', 'works.user', 'works.user.visibleSpecialties']) !!}'),
                load: moment('{!! \Carbon\Carbon::now()->toDateTimeString() !!}'),
                mando: {{ Auth::user()->isMando() ? "true" : "false" }},
                loading: false,
                timer: null,
                ended: false,
            },
            created: function () {
              this.timer = setInterval(this.update, 60000);
            },
            methods: {
              kick: function (work) {
                  if(confirm('¿Echar a ' + work.user.name + ' del servicio? No podrá volver a entrar hasta el siguiente.')) {
                      axios.post('/api/session/kick',{
                          work_id: work.id,
                      }).then(function(response) {
                            Materialize.toast(work.user.name + " expulsado del servicio correctamente");
                            vm.update();
                          })
                          .catch(function(error) {
                              Materialize.toast("No ha sido posible expulsar a " + work.user.name + " del servicio (" + error.response.status + ")");
                          });
                  }
              },
              update: function() {
                  axios.get('/api/session')
                      .then(function(response) {
                          this.gameSession = response.data;
                          this.loading = false;
                          this.load = moment(new Date());
                      }.bind(this))
                      .catch(function (error) {
                          vm.loading = false;
                          console.log(error.response.status);
                          if(error.response.status === 404) {
                              vm.ended = true;
                              clearInterval(vm.timer);
                          }
                      });
              }
            },
            beforeDestroy: function() {
                clearInterval(this.timer)
            },
            computed: {
                orderedWorks: function() {
                    return _.orderBy(this.gameSession.works, ['user.corp', 'user.rank', 'user.name'], ['desc', 'desc', 'desc']);
                }
            }

        });
    </script>
@endsection