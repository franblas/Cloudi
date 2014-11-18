package graphics;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.sql.SQLException;
import java.util.ArrayList;

import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JMenu;
import javax.swing.JMenuBar;
import javax.swing.JMenuItem;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JPasswordField;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;
import javax.swing.JTextField;
import javax.swing.UIManager;
import javax.swing.UnsupportedLookAndFeelException;

import org.jfree.chart.ChartFactory;
import org.jfree.chart.ChartPanel;
import org.jfree.chart.JFreeChart;
import org.jfree.data.general.DefaultPieDataset;

import server.FileSystem;
import server.SqlServer;
import server.SshServer;
import server.WebServer;
import utils.BashUtils;
import utils.Configuration;

import com.mysql.jdbc.Connection;

import database.ConnectionDB;
import database.db;

import autosuggestion.AutoSuggestor;

/**
 * 
 * @author Paco
 *
 */
public class MainFrame extends JFrame implements ActionListener, MouseListener{
	
	/**
	Les panneaux
	**/
	private JPanel pan = new JPanel(); //Panneau principal
	private JPanel pan2 = new JPanel();
	private JPanel pan3 = new JPanel();
	private JPanel pan4 = new JPanel();
	private JPanel panco = new JPanel();
	private JPanel panco1 = new JPanel();

	/**
	Les boutons
	**/
	private JButton bouton_apache_start = new JButton(); //bouton start apache
	private JButton bouton_apache_stop = new JButton(); //bouton stop apache
	private JButton bouton_mysql_start = new JButton(); //bouton start mysql
	private JButton bouton_mysql_stop = new JButton(); //bouton stop mysql
	private JButton bouton_ssh_start = new JButton(); //bouton start openssh
	private JButton bouton_ssh_stop = new JButton(); //bouton stop openssh
	private JButton bouton_apache_infos = new JButton(); //bouton open news file apache
	private JButton bouton_mysql_infos = new JButton(); //bouton open news file mysql
	private JButton bouton_ssh_infos = new JButton(); //bouton open news file ssh
	private JButton bouton_showfile = new JButton(); //bouton showfile
	private JButton bouton_htop = new JButton(); //bouton launch htop
	private JButton bouton_useraccount = new JButton(); //bouton launch user account creation
	private JButton bouton_user_application = new JButton(); //bouton launch who use this application
	private JButton bouton_infoswww = new JButton(); //bouton infos serveur web
	private JButton bouton_connexion = new JButton(); //bouton infos serveur web

	/**
	* Les Labels
	**/
	private JLabel label_apache = new JLabel("Apache",JLabel.CENTER);
	private JLabel label_mysql = new JLabel("MySQL",JLabel.CENTER);
	private JLabel label_ssh = new JLabel("OpenSSH",JLabel.CENTER);
	private JLabel label_htop = new JLabel("Process, mem, cpu ...",JLabel.CENTER);
	private JLabel label_status_apache = new JLabel("");
	private JLabel label_status_mysql = new JLabel("");
	private JLabel label_status_ssh = new JLabel("");
	private JLabel label_useraccount = new JLabel("Creation comptes utilisateur",JLabel.CENTER);
	private JLabel label_infoswww = new JLabel("Infos Serveur Web",JLabel.CENTER);
	private JLabel label_connexion_user = new JLabel("Username",JLabel.CENTER);
	private JLabel label_connexion_password = new JLabel("Password root",JLabel.CENTER);
	private JLabel label_connexion_password2 = new JLabel("Password db",JLabel.CENTER);
	
	/**
	* Les champs textes
	**/
	private JTextField text_showfile = new JTextField();
	private JTextField text_user_application = new JTextField();
	private JTextField text_connexion_user = new JTextField("paco");
	private JPasswordField text_connexion_password = new JPasswordField("sunpaco35@P");
	private JPasswordField text_connexion_password2 = new JPasswordField("pacoMySQL@35");

	/**
	 * Variables de connexion
	 */
	private String connexion_username = new String();
	private String connexion_password = new String();
	private String connexion_password2 = new String();
	private Connection co = null;

	/**
	* Les menus + items menus
	*/
	private JMenuBar menuBar = new JMenuBar();
	private JMenu menu_fichier = new JMenu("Fichier");
	private JMenu menu_outils = new JMenu("Outils");
	private JMenu menu_affichage = new JMenu("Affichage");
	private JMenu menu_aide = new JMenu("Aide");
	//items fichier
	private JMenuItem menu_item_sauvegarder = new JMenuItem("Sauvegarder");
	private JMenuItem menu_item_fermer = new JMenuItem("Fermer");
	//items outils
	private JMenuItem menu_item_applications = new JMenuItem("Ajouter Application");
	private JMenuItem menu_item_fluxrss = new JMenuItem("Ajouter Flux RSS");
	private JMenuItem menu_item_voirvms = new JMenuItem("Voir VMs");
	private JMenuItem menu_item_stockageuser = new JMenuItem("Stockage Utilisateur");
	private JMenuItem menu_item_configfichiers = new JMenuItem("Configuration Fichiers");
	private JMenuItem menu_item_seeappli = new JMenuItem("Voir applications installees");
	//items aide
	private JMenuItem menu_item_contact = new JMenuItem("Contact");
	private JMenuItem menu_item_tutoriel = new JMenuItem("Tutoriel");
	private JMenuItem menu_item_apropos = new JMenuItem("A propos");
	//items affichage
	private JMenuItem menu_item_refresh = new JMenuItem("Refresh");

	/**
	 * 
	 * @param nom
	 * @param largeur
	 * @param hauteur
	 */
	public MainFrame(String nom,int largeur, int hauteur){
		
		//set OS style
		try {UIManager.setLookAndFeel(UIManager.getSystemLookAndFeelClassName());} 
		catch (ClassNotFoundException e1) {e1.printStackTrace();} 
		catch (InstantiationException e1) {e1.printStackTrace();} 
		catch (IllegalAccessException e1) {e1.printStackTrace();} 
		catch (UnsupportedLookAndFeelException e1) {e1.printStackTrace();}
		
		//Frame options
		this.setTitle(nom); //Titre de la Fenetre
		this.setSize(largeur,hauteur); //taille de la fen�tre en pixels
		this.setBackground(Color.WHITE); //Fond de la fen�tre
		//Chargement du logo de la fen�tre depuis le dossier source images dans le jar
		ClassLoader classloader = getClass().getClassLoader(); //lignes permettant de compil � l'image dans le jar
		java.net.URL icofenetre = classloader.getResource("images/cloudiicon.png"); //declaration de l'image sous forme d'url
		this.setIconImage(new ImageIcon(icofenetre).getImage()); //ajout de l'icone a la fen �tre
		this.setLocationRelativeTo(null); //Positionnement au centre
		this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE); //Termine le processus lorsqu'on clique sur la croix rouge
		this.setResizable(false); //Empeche/Autorise redimensionnement
		this.setAlwaysOnTop(false); //Toujours/Jamais au 1er plan
		
		//boutons config
		bouton_apache_start.setToolTipText("Start Apache"); //Message au passage du curseur
		bouton_apache_start.setText("Start"); //Titre du bouton
		bouton_apache_stop.setToolTipText("Stop Apache"); //Message au passage du curseur
		bouton_apache_stop.setText("Stop"); //Titre du bouton
		bouton_apache_infos.setToolTipText("Infos Apache"); //Message au apssage du curseur
		bouton_apache_infos.setText("Infos"); //Titre du bouton
		bouton_mysql_start.setToolTipText("Start MySQL"); //Message au passage du curseur
		bouton_mysql_start.setText("Start"); //Titre du bouton
		bouton_mysql_stop.setToolTipText("Stop MySQL"); //Message au passage du curseur
		bouton_mysql_stop.setText("Stop"); //Titre du bouton
		bouton_mysql_infos.setToolTipText("Infos MySQL"); //Message au apssage du curseur
		bouton_mysql_infos.setText("Infos"); //Titre du bouton
		bouton_ssh_start.setToolTipText("Start OpenSSH"); //Message au passage du curseur
		bouton_ssh_start.setText("Start"); //Titre du bouton
		bouton_ssh_stop.setToolTipText("Stop OpenSSH"); //Message au passage du curseur
		bouton_ssh_stop.setText("Stop"); //Titre du bouton
		bouton_ssh_infos.setToolTipText("Infos OpenSSH"); //Message au apssage du curseur
		bouton_ssh_infos.setText("Infos"); //Titre du bouton
		bouton_htop.setToolTipText("Start htop"); //Message au passage du curseur
		bouton_htop.setText("htop"); //Titre du bouton
		bouton_showfile.setToolTipText("Voir un fichier"); //Message au passage du curseur
		bouton_showfile.setText("Voir fichier"); //Titre du bouton
		bouton_useraccount.setText("Creer compte utilisateur"); //Titre du bouton
		bouton_useraccount.setToolTipText("Creer compte utilisateur"); //Message au passage du curseur
		bouton_user_application.setText("Utilisation Application"); //Titre du bouton
		bouton_user_application.setToolTipText("Voir utilisateurs qui utilisent cette application"); //Message au passage du curseur
		bouton_infoswww.setText("Infos Serveur Web"); //Titre du bouton
		bouton_infoswww.setToolTipText("Voir infos serveur web"); //Message au passage du curseur
		bouton_connexion.setText("Connexion"); //Titre du bouton
		bouton_connexion.setToolTipText("Connexion"); //Message au passage du curseur
		this.getRootPane().setDefaultButton(bouton_connexion);

		//ecoute mouse
		bouton_apache_start.addMouseListener(this);
		bouton_apache_stop.addMouseListener(this);
		bouton_apache_infos.addMouseListener(this);
		bouton_mysql_start.addMouseListener(this);
		bouton_mysql_stop.addMouseListener(this);
		bouton_mysql_infos.addMouseListener(this);
		bouton_ssh_start.addMouseListener(this);
		bouton_ssh_stop.addMouseListener(this);
		bouton_ssh_infos.addMouseListener(this);
		bouton_htop.addMouseListener(this);
		bouton_showfile.addMouseListener(this);
		bouton_useraccount.addMouseListener(this);
		bouton_infoswww.addMouseListener(this);

		bouton_user_application.addMouseListener(this);
		
		//Autocompletion Application et virtualbox
		/*AutoSuggestor autoSuggestor = new AutoSuggestor(text_user_application, this, null, Color.WHITE.brighter(), Color.BLUE, Color.RED, 0.75f) {
		    protected boolean wordTyped(String typedWord) {
		        //create list for dictionary this in your case might be done via calling a method which queries db and returns results as arraylist
		        ArrayList<String> words = new ArrayList<String>();
		        ArrayList<String> applist = new db().applicationBDDList(conn);
		        words.add("virtualbox");
		        for(int k=0;k<applist.size();k++){
		        	words.add(applist.get(k));
		        }      
		        setDictionary(words);
		        //addToDictionary("bye");//adds a single word
		        return super.wordTyped(typedWord);//now call super to check for any matches against newest dictionary
		    }
		};*/
		
		//ecoute event
		bouton_connexion.addActionListener(this);
		menu_item_apropos.addActionListener(this);
		menu_item_refresh.addActionListener(this);
		menu_item_fermer.addActionListener(this);
		menu_item_applications.addActionListener(this);
		menu_item_fluxrss.addActionListener(this);
		menu_item_voirvms.addActionListener(this);
		menu_item_stockageuser.addActionListener(this);
		menu_item_configfichiers.addActionListener(this);
		menu_item_seeappli.addActionListener(this);
		//ajout menus et items menus
		this.menu_fichier.add(menu_item_sauvegarder);
		menu_fichier.addSeparator();
		this.menu_fichier.add(menu_item_fermer);
		this.menu_outils.add(menu_item_applications);
		this.menu_outils.add(menu_item_fluxrss);
		this.menu_outils.add(menu_item_voirvms);
		this.menu_outils.add(menu_item_stockageuser);
		this.menu_outils.add(menu_item_configfichiers);
		this.menu_outils.add(menu_item_seeappli);
		this.menu_affichage.add(menu_item_refresh);
		this.menu_aide.add(menu_item_tutoriel);
		this.menu_aide.add(menu_item_contact);
		this.menu_aide.add(menu_item_apropos);
		this.menuBar.add(menu_fichier);
		this.menuBar.add(menu_outils);
		this.menuBar.add(menu_affichage);
		this.menuBar.add(menu_aide);
		this.setJMenuBar(menuBar);
		menuBar.setVisible(false);
		
		//layout config
		GridLayout gridpan1 = new GridLayout(0,1);
		GridLayout gridpan2 = new GridLayout(0,2); 
		GridLayout gridpan5 = new GridLayout(0,5);
		pan.setLayout(gridpan1);
		pan2.setLayout(gridpan5);
		pan3.setLayout(gridpan2);
		pan4.setLayout(gridpan2);
		panco.setLayout(gridpan1);panco1.setLayout(gridpan2);
		
		//add components to panels
		pan2.add(label_apache);
		pan2.add(bouton_apache_start);
		pan2.add(bouton_apache_stop);
		pan2.add(bouton_apache_infos);
		pan2.add(label_status_apache);
		pan2.add(label_mysql);
		pan2.add(bouton_mysql_start);
		pan2.add(bouton_mysql_stop);
		pan2.add(bouton_mysql_infos);
		pan2.add(label_status_mysql);
		pan2.add(label_ssh);
		pan2.add(bouton_ssh_start);
		pan2.add(bouton_ssh_stop);
		pan2.add(bouton_ssh_infos);
		pan2.add(label_status_ssh);
		pan3.add(text_showfile);
		pan3.add(bouton_showfile);
		pan3.add(label_htop);
		pan3.add(bouton_htop);
		pan3.add(label_useraccount);
		pan3.add(bouton_useraccount);
		pan3.add(text_user_application);
		pan3.add(bouton_user_application);
		pan3.add(label_infoswww);
		pan3.add(bouton_infoswww);
		//pan3.add(label_status_cale);
		pan.add(pan2);
		//pan.add(pan4);
		pan.add(pan3);

		panco1.add(label_connexion_user);
		panco1.add(text_connexion_user);
		panco1.add(label_connexion_password);
		panco1.add(text_connexion_password);
		panco1.add(label_connexion_password2);
		panco1.add(text_connexion_password2);
		panco1.add(bouton_connexion);
		panco.add(panco1);

		this.getContentPane().add(panco1);

		this.setVisible(true);
	}
	
	@Override
	public void actionPerformed(ActionEvent event) {
		if(event.getSource() == menu_item_apropos){
			JOptionPane.showMessageDialog(null,"Configuration Cloudi \n Powered by Cloudi Inc. \n \u00a9 Tous Droits Réservés","A Propos",JOptionPane.INFORMATION_MESSAGE);
		}
		if(event.getSource() == menu_item_refresh){
			new WebServer(connexion_password,label_status_apache).labelStatus_apache();
			new SqlServer(connexion_password,label_status_mysql).labelStatus_mysql();
			new SshServer(connexion_password,label_status_ssh).labelStatus_ssh();
		}
		if(event.getSource() == menu_item_fermer){
			int option = JOptionPane.showConfirmDialog(null,"Voulez-vous quitter ?","Arrêt de Cloudi Configuration",JOptionPane.YES_NO_CANCEL_OPTION,JOptionPane.QUESTION_MESSAGE);
			if(option != JOptionPane.NO_OPTION && option != JOptionPane.CANCEL_OPTION &&
			option != JOptionPane.CLOSED_OPTION){
				System.exit(0);
			}
		}
		if(event.getSource() == menu_item_fluxrss){
			//lancer fenetre actu
			new NewsFrame("Cloudi - Ajouter Actualite",800,600,co,connexion_password);
		}
		if(event.getSource() == menu_item_applications){
			//lancer fenetre appli
			new AppliFrame("Cloudi - Ajouter Application",800,600,co,connexion_password);
		}
		if(event.getSource() == menu_item_stockageuser){
			ArrayList<String> userlist = new db().userBDDList(co);
			String toto = "";
			DefaultPieDataset pieDataset = new DefaultPieDataset();
			for(int k=0;k<userlist.size();k++){
				toto = new BashUtils().outputCommand("du -c /home/"+userlist.get(k)+" | grep total",""+connexion_password);
				toto = toto.replace("total","");
				toto = toto.trim();
				pieDataset.setValue(userlist.get(k),Double.parseDouble(toto));
			}
			JFreeChart pieChart = ChartFactory.createPieChart("Espace Stockage Utilisateurs",pieDataset,true,false,false);
			ChartPanel cPanel = new ChartPanel(pieChart);
			JPanel textarea = new JPanel();
			textarea.add(cPanel);
			JScrollPane scrollpane = new JScrollPane(textarea); //utilisation d'un panneau scrollé pour des longs fichiers
			scrollpane.setPreferredSize(new Dimension(700,500));
			JOptionPane.showMessageDialog(null,scrollpane,"Espace Stockage Utilisateurs",JOptionPane.INFORMATION_MESSAGE);
		}
		if(event.getSource() == menu_item_voirvms){
			new VMFrame("Cloudi - VMs",800,600,co,connexion_password);
		}
		if(event.getSource() == menu_item_configfichiers){
			new FilesFrame("Cloudi - Fichiers",800,600,connexion_password);
		}
		if(event.getSource() == menu_item_seeappli){
			new AppliSeeFrame("Cloudi - Applications installees",550,380,co,connexion_password);
		}
		if(event.getSource() == bouton_connexion){
			if(text_connexion_user.getText()!=null && text_connexion_password.getText()!=null){
				if(text_connexion_user.getText().equals(new Configuration().USER_UNIX) && text_connexion_password.getText().equals(new Configuration().PASSWORD_SUDO_UNIX) && text_connexion_password2.getText().equals(new Configuration().PASSWORD_DB_SQL)){
					connexion_username = text_connexion_user.getText();
					connexion_password = text_connexion_password.getText();
					connexion_password2 = text_connexion_password2.getText();
					try {
						co = (Connection) new ConnectionDB(connexion_password2, "test", "").connection();
					} catch (ClassNotFoundException e) {
						e.printStackTrace();
					} catch (SQLException e) {
						e.printStackTrace();
					}
					panco1.setVisible(false);
					menuBar.setVisible(true);
					//Label suivant status services
					new WebServer(connexion_password,label_status_apache).labelStatus_apache();
					new SqlServer(connexion_password,label_status_mysql).labelStatus_mysql();
					new SshServer(connexion_password,label_status_ssh).labelStatus_ssh();
					this.getContentPane().add(new JScrollPane(pan),BorderLayout.CENTER);
				}
				else{
					JOptionPane.showMessageDialog(null,"Mauvais login/password !","Erreur Login",JOptionPane.ERROR_MESSAGE);
				}
			}
		}	
	}//end actionPerformed

	//Variables utiles pour copie fichier
	public String path_iconeappli =null;public String name_iconeappli =null;
	public String path_slideappli1 =null;public String name_slideappli1 =null;
	public String path_slideappli2 =null;public String name_slideappli2 =null;
	public String path_slideappli3 =null;public String name_slideappli3 =null;
	public String path_slideappli4 =null;public String name_slideappli4 =null;
	public String path_slideappli5 =null;public String name_slideappli5 =null;
	
	@Override
	public void mouseClicked(MouseEvent arg0) {
		if(arg0.getSource() == bouton_apache_start){
			try {
				String[] com = {"/bin/bash","-c","echo '"+connexion_password+"' | sudo -S service apache2 start"};
				Runtime.getRuntime().exec(com);
				label_status_apache.setText("Apache Start");
				label_status_apache.setForeground(new Color(0,255,0)); //green boite_dialogue.showMessageDialog(null,"Apache est demarre","Succes Apache",JOptionPane.INFORMATION_MESSAGE);
			}
			catch (Exception e) {
				e.printStackTrace();
				JOptionPane.showMessageDialog(null,"Erreur au demarrage d'Apache","Erreur Apache",JOptionPane.INFORMATION_MESSAGE);
			}
		}
		if(arg0.getSource() == bouton_apache_stop){
			int option = JOptionPane.showConfirmDialog(null,"Voulez-vous stopper apache ?","Arrêt de Apache",JOptionPane.YES_NO_CANCEL_OPTION,JOptionPane.QUESTION_MESSAGE);
			if(option != JOptionPane.NO_OPTION && option != JOptionPane.CANCEL_OPTION &&
			option != JOptionPane.CLOSED_OPTION){
				try {
					String[] com = {"/bin/bash","-c","echo '"+connexion_password+"' | sudo -S service apache2 stop"};
					Runtime.getRuntime().exec(com);
					label_status_apache.setText("Apache Stop");
					label_status_apache.setForeground(new Color(255,0,0)); //red
					JOptionPane.showMessageDialog(null,"Apache est arrete","Succes Apache",JOptionPane.INFORMATION_MESSAGE);
				}
				catch (Exception e) {
					e.printStackTrace();
					JOptionPane.showMessageDialog(null,"Erreur a l'arret d'Apache","Erreur Apache",JOptionPane.INFORMATION_MESSAGE);
				}
			}
		}
		if(arg0.getSource() == bouton_apache_infos){
			JOptionPane.showMessageDialog(null,new WebServer(connexion_password,label_status_apache).listenPort_apache(),"Infos Apache",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_mysql_start){
			try {
				String[] com = {"/bin/bash","-c","echo '"+connexion_password+"' | sudo -S service mysql start"};
				Runtime.getRuntime().exec(com);
				label_status_mysql.setText("MySQL Start");
				label_status_mysql.setForeground(new Color(0,255,0)); //green
				JOptionPane.showMessageDialog(null,"MySQL est demarre","Succes MySQL",JOptionPane.INFORMATION_MESSAGE);
			}
			catch (Exception e) {
				e.printStackTrace();
				JOptionPane.showMessageDialog(null,"Erreur au demarrage de MySQL","Erreur MySQL",JOptionPane.INFORMATION_MESSAGE);
			}
		}
		if(arg0.getSource() == bouton_mysql_stop){
			int option = JOptionPane.showConfirmDialog(null,"Voulez-vous stopper MySQL ?","Arrêt de MySQL",JOptionPane.YES_NO_CANCEL_OPTION,JOptionPane.QUESTION_MESSAGE);
			if(option != JOptionPane.NO_OPTION && option != JOptionPane.CANCEL_OPTION &&
			option != JOptionPane.CLOSED_OPTION){	
				try {
					String[] com = {"/bin/bash","-c","echo '"+connexion_password+"' | sudo -S service mysql stop"};
					Runtime.getRuntime().exec(com);
					label_status_mysql.setText("MySQL Stop");
					label_status_mysql.setForeground(new Color(255,0,0)); //red
					JOptionPane.showMessageDialog(null,"MySQL est arrete","Succes MySQL",JOptionPane.INFORMATION_MESSAGE);
				}
				catch (Exception e) {
					e.printStackTrace();
					JOptionPane.showMessageDialog(null,"Erreur a l'arret de MySQL","Erreur MySQL",JOptionPane.INFORMATION_MESSAGE);
				}
			}
		}
		if(arg0.getSource() == bouton_mysql_infos){
			JOptionPane.showMessageDialog(null,new SqlServer(connexion_password,label_status_mysql).listenPort_mysql(),"Infos MySQL",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_ssh_start){
			try {
				String[] com = {"/bin/bash","-c","echo '"+connexion_password+"' | sudo -S service ssh start"};
				Runtime.getRuntime().exec(com);
				label_status_ssh.setText("OpenSSH Start");
				label_status_ssh.setForeground(new Color(0,255,0)); //green
				JOptionPane.showMessageDialog(null,"OpenSSH est demarre","Succes OpenSSH",JOptionPane.INFORMATION_MESSAGE);
			}
			catch (Exception e) {
				e.printStackTrace();
				JOptionPane.showMessageDialog(null,"Erreur au demarrage d'OpenSSH","Erreur OpenSSH",JOptionPane.INFORMATION_MESSAGE);
			}
		}
		if(arg0.getSource() == bouton_ssh_stop){
			int option = JOptionPane.showConfirmDialog(null,"Voulez-vous stopper SSH ?","Arrêt de SSH",JOptionPane.YES_NO_CANCEL_OPTION,JOptionPane.QUESTION_MESSAGE);
			if(option != JOptionPane.NO_OPTION && option != JOptionPane.CANCEL_OPTION &&
			option != JOptionPane.CLOSED_OPTION){
				try {
					String[] com = {"/bin/bash","-c","echo '"+connexion_password+"' | sudo -S service ssh stop"};
					Runtime.getRuntime().exec(com);
					label_status_ssh.setText("OpenSSH Stop");
					label_status_ssh.setForeground(new Color(255,0,0)); //red
					JOptionPane.showMessageDialog(null,"OpenSSH est arrete","Succes OpenSSH",JOptionPane.INFORMATION_MESSAGE);
				}
				catch (Exception e) {
					e.printStackTrace();
					JOptionPane.showMessageDialog(null,"Erreur a l'arret d'OpenSSH","Erreur OpenSSH",JOptionPane.INFORMATION_MESSAGE);
				}
			}
		}
		if(arg0.getSource() == bouton_ssh_infos){
			JOptionPane.showMessageDialog(null,new SshServer(connexion_password,label_status_ssh).listenPort_ssh(),"Infos OpenSSH",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_htop){
			try {
				Runtime.getRuntime().exec("xterm htop");
			}
			catch (Exception e) {
				e.printStackTrace();
			}
		}
		if(arg0.getSource() == bouton_showfile){
			new FileSystem(connexion_password).showFile(text_showfile.getText());
		}
		if(arg0.getSource() == bouton_useraccount){
			/*try {
			String[] com = {"/bin/bash","-c","echo '"+connexion_password+"' | sudo -S /home/paco/useraccount.sh"};
			Runtime.getRuntime().exec(com);
			boite_dialogue.showMessageDialog(null,"Utilisateurs Crees !","Succes creation utilisateurs",JOptionPane.INFORMATION_MESSAGE);
			}
			catch (Exception e) {
			e.printStackTrace();
			boite_dialogue.showMessageDialog(null,"Erreur creation utilisateurs","Erreur creation utilisateurs",JOptionPane.INFORMATION_MESSAGE);
			}*/
				
		}
		if(arg0.getSource() == bouton_user_application){
			String toto = new BashUtils().outputCommand("ps aux | grep "+text_user_application.getText(),""+connexion_password);
			JTextArea textarea = new JTextArea(toto); //remplissage panneau scrollé
			JScrollPane scrollpane = new JScrollPane(textarea); //utilisation d'un panneau scrollé pour des longs fichiers
			textarea.setLineWrap(true);
			textarea.setWrapStyleWord(true);
			scrollpane.setPreferredSize(new Dimension(200,200));
			JOptionPane.showMessageDialog(null,scrollpane,"Utilisation de "+text_user_application.getText(),JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_infoswww){
				JOptionPane.showMessageDialog(null,new WebServer(connexion_password,label_status_apache).infos_www(),"Infos Serveur Web",JOptionPane.INFORMATION_MESSAGE);
		}
	}//end mouseClicked

	@Override
	public void mouseEntered(MouseEvent arg0) {
	}

	@Override
	public void mouseExited(MouseEvent arg0) {
	}

	@Override
	public void mousePressed(MouseEvent arg0) {
	}

	@Override
	public void mouseReleased(MouseEvent arg0) {
	}

}//end of class

