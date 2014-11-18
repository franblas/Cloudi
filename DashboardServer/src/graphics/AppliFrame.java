package graphics;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.GridLayout;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.io.File;

import javax.swing.JButton;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextField;
import javax.swing.filechooser.FileNameExtensionFilter;

import server.FileSystem;
import utils.PicturesUtils;

import com.mysql.jdbc.Connection;

import database.db;

/**
 * 
 * @author Paco
 *
 */
public class AppliFrame extends JFrame implements MouseListener{

	/**
	Les panneaux
	**/
	private JPanel pan = new JPanel(); //Panneau principal
	private JPanel pan4 = new JPanel();
	
	/**
	 * Les boutons
	 */
	private JButton bouton_bdd_appli = new JButton(); //bouton launch bdd appli request
	private JButton bouton_iconeappli = new JButton(); //bouton 
	private JButton bouton_slideappli1= new JButton(); //bouton 
	private JButton bouton_slideappli2 = new JButton(); //bouton 
	private JButton bouton_slideappli3 = new JButton(); //bouton 
	private JButton bouton_slideappli4 = new JButton(); //bouton 
	private JButton bouton_slideappli5 = new JButton(); //bouton 
	
	/**
	 * Les Labels
	 */
	private JLabel label_bdd_appli_cale2 = new JLabel("");
	private JLabel label_bdd_appli_name = new JLabel("Nom Application",JLabel.CENTER);
	private JLabel label_bdd_appli_nomcom = new JLabel("Nom Commande",JLabel.CENTER);
	private JLabel label_bdd_appli_lienweb = new JLabel("Lien Web",JLabel.CENTER);
	private JLabel label_bdd_appli_categorie = new JLabel("Categorie",JLabel.CENTER);
	private JLabel label_bdd_appli_description = new JLabel("Description",JLabel.CENTER);
	private JLabel label_bdd_appli_developer = new JLabel("Developer",JLabel.CENTER);
	private JLabel label_bdd_appli_version = new JLabel("Version",JLabel.CENTER);
	private JLabel label_iconeappli = new JLabel("Icone Application",JLabel.CENTER);
	private JLabel label_slideappli1 = new JLabel("Image 1 slide Application",JLabel.CENTER);
	private JLabel label_slideappli2 = new JLabel("Image 2 slide Application",JLabel.CENTER);
	private JLabel label_slideappli3 = new JLabel("Image 3 slide Application",JLabel.CENTER);
	private JLabel label_slideappli4 = new JLabel("Image 4 slide Application",JLabel.CENTER);
	private JLabel label_slideappli5 = new JLabel("Image 5 slide Application",JLabel.CENTER);
	
	/**
	 * les champs texte
	 */
	private JTextField text_bdd_appli_name = new JTextField();
	private JTextField text_bdd_appli_nomcom = new JTextField();
	private JTextField text_bdd_appli_lienweb = new JTextField();
	private JTextField text_bdd_appli_categorie = new JTextField();
	private JTextField text_bdd_appli_description = new JTextField();
	private JTextField text_bdd_appli_developer = new JTextField();
	private JTextField text_bdd_appli_version = new JTextField();
	
	/**
	 * Useful
	 */
	private Connection co = null;
	private String sudopass = "";
	
	/**
	 * 
	 * @param nom
	 * @param largeur
	 * @param hauteur
	 */
	public AppliFrame(String nom,int largeur, int hauteur,Connection conn, String passsudo){
		this.co = conn;
		this.sudopass = passsudo;
		
		//Frame options
		this.setTitle(nom); //Titre de la Fenetre
		this.setSize(largeur,hauteur); //taille de la fen�tre en pixels
		this.setBackground(Color.WHITE); //Fond de la fen�tre
		this.setLocationRelativeTo(null); //Positionnement au centre
		this.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE); //Termine le processus lorsqu'on clique sur la croix rouge
		this.setResizable(false); //Empeche/Autorise redimensionnement
		this.setAlwaysOnTop(false); //Toujours/Jamais au 1er plan
		
		//Bountons configuration
		bouton_bdd_appli.setToolTipText("Add application"); //Message au passage du curseur
		bouton_bdd_appli.setText("Application"); //Titre du bouton
		bouton_iconeappli.setText("Icone Application");
		bouton_iconeappli.setToolTipText("Selectionner une image pour l'application");
		bouton_slideappli1.setText("Slide Application");
		bouton_slideappli1.setToolTipText("Selectionner une image pour le slide de l'application");
		bouton_slideappli2.setText("Slide Application");
		bouton_slideappli2.setToolTipText("Selectionner une image pour le slide de l'application");
		bouton_slideappli3.setText("Slide Application");
		bouton_slideappli3.setToolTipText("Selectionner une image pour le slide de l'application");
		bouton_slideappli4.setText("Slide Application");
		bouton_slideappli4.setToolTipText("Selectionner une image pour le slide de l'application");
		bouton_slideappli5.setText("Slide Application");
		bouton_slideappli5.setToolTipText("Selectionner une image pour le slide de l'application");
		
		bouton_bdd_appli.addMouseListener(this);
		bouton_iconeappli.addMouseListener(this);
		bouton_slideappli1.addMouseListener(this);
		bouton_slideappli2.addMouseListener(this);
		bouton_slideappli3.addMouseListener(this);
		bouton_slideappli4.addMouseListener(this);
		bouton_slideappli5.addMouseListener(this);
		
		//layout configuration
		GridLayout gridpan1 = new GridLayout(0,1);
		GridLayout gridpan2 = new GridLayout(0,2);
		pan.setLayout(gridpan1);
		pan4.setLayout(gridpan2);
		
		//Add components to panel
		pan4.add(label_bdd_appli_name);
		pan4.add(text_bdd_appli_name);
		pan4.add(label_bdd_appli_nomcom);
		pan4.add(text_bdd_appli_nomcom);
		pan4.add(label_bdd_appli_lienweb);
		pan4.add(text_bdd_appli_lienweb);
		pan4.add(label_bdd_appli_categorie);
		pan4.add(text_bdd_appli_categorie);
		pan4.add(label_bdd_appli_description);
		pan4.add(text_bdd_appli_description);
		pan4.add(label_bdd_appli_developer);
		pan4.add(text_bdd_appli_developer);
		pan4.add(label_bdd_appli_version);
		pan4.add(text_bdd_appli_version);
		pan4.add(label_iconeappli);
		pan4.add(bouton_iconeappli);
		pan4.add(label_slideappli1);
		pan4.add(bouton_slideappli1);
		pan4.add(label_slideappli2);
		pan4.add(bouton_slideappli2);
		pan4.add(label_slideappli3);
		pan4.add(bouton_slideappli3);
		pan4.add(label_slideappli4);
		pan4.add(bouton_slideappli4);
		pan4.add(label_slideappli5);
		pan4.add(bouton_slideappli5);
		pan4.add(label_bdd_appli_cale2);
		pan4.add(bouton_bdd_appli);
		
		pan.add(pan4);
		
		this.getContentPane().add(new JScrollPane(pan),BorderLayout.CENTER);

		this.setVisible(true);
	}
	
	//Variables utiles pour copie fichier
	public String path_iconeappli =null;public String name_iconeappli =null;
	public String path_slideappli1 =null;public String name_slideappli1 =null;
	public String path_slideappli2 =null;public String name_slideappli2 =null;
	public String path_slideappli3 =null;public String name_slideappli3 =null;
	public String path_slideappli4 =null;public String name_slideappli4 =null;
	public String path_slideappli5 =null;public String name_slideappli5 =null;

	@Override
	public void mouseClicked(MouseEvent arg0) {
		if(arg0.getSource() == bouton_iconeappli){
			JFileChooser choose_iconeappli = new JFileChooser();
			choose_iconeappli.setFileFilter(new FileNameExtensionFilter("Fichier PNG","png"));
			File iconeappli;

			if (choose_iconeappli.showOpenDialog(null)== JFileChooser.APPROVE_OPTION){
				iconeappli = choose_iconeappli.getSelectedFile();
			    path_iconeappli = iconeappli.getPath();
			    name_iconeappli = iconeappli.getName();
			    bouton_iconeappli.setText(name_iconeappli);
			    bouton_iconeappli.setBackground(new Color(0,255,0));
			}
			//boite_dialogue.showMessageDialog(null,infos_www(),"Infos Serveur Web",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_slideappli1){
			JFileChooser choose_slideappli1 = new JFileChooser();
			File slideappli1;

			if (choose_slideappli1.showOpenDialog(null)== JFileChooser.APPROVE_OPTION){
				slideappli1 = choose_slideappli1.getSelectedFile();
			    path_slideappli1 = slideappli1.getPath();
			    name_slideappli1 = slideappli1.getName();
			    bouton_slideappli1.setText(name_slideappli1);
			    bouton_slideappli1.setBackground(new Color(0,255,0));
			}
			//boite_dialogue.showMessageDialog(null,infos_www(),"Infos Serveur Web",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_slideappli2){
			JFileChooser choose_slideappli2 = new JFileChooser();
			File slideappli2;

			if (choose_slideappli2.showOpenDialog(null)== JFileChooser.APPROVE_OPTION){
				slideappli2 = choose_slideappli2.getSelectedFile();
			    path_slideappli2 = slideappli2.getPath();
			    name_slideappli2 = slideappli2.getName();
			    bouton_slideappli2.setText(name_slideappli2);
			    bouton_slideappli2.setBackground(new Color(0,255,0));
			}
			//boite_dialogue.showMessageDialog(null,infos_www(),"Infos Serveur Web",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_slideappli3){
			JFileChooser choose_slideappli3 = new JFileChooser();
			File slideappli3;

			if (choose_slideappli3.showOpenDialog(null)== JFileChooser.APPROVE_OPTION){
				slideappli3 = choose_slideappli3.getSelectedFile();
			    path_slideappli3 = slideappli3.getPath();
			    name_slideappli3 = slideappli3.getName();
			    bouton_slideappli3.setText(name_slideappli3);
			    bouton_slideappli3.setBackground(new Color(0,255,0));
			}
			//boite_dialogue.showMessageDialog(null,infos_www(),"Infos Serveur Web",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_slideappli4){
			JFileChooser choose_slideappli4 = new JFileChooser();
			File slideappli4;

			if (choose_slideappli4.showOpenDialog(null)== JFileChooser.APPROVE_OPTION){
				slideappli4 = choose_slideappli4.getSelectedFile();
			    path_slideappli4 = slideappli4.getPath();
			    name_slideappli4 = slideappli4.getName();
			    bouton_slideappli4.setText(name_slideappli4);
			    bouton_slideappli4.setBackground(new Color(0,255,0));
			}
			//boite_dialogue.showMessageDialog(null,infos_www(),"Infos Serveur Web",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_slideappli5){
			JFileChooser choose_slideappli5 = new JFileChooser();
			File slideappli5;

			if (choose_slideappli5.showOpenDialog(null)== JFileChooser.APPROVE_OPTION){
				slideappli5 = choose_slideappli5.getSelectedFile();
			    path_slideappli5 = slideappli5.getPath();
			    name_slideappli5 = slideappli5.getName();
			    bouton_slideappli5.setText(name_slideappli5);
			    bouton_slideappli5.setBackground(new Color(0,255,0));
			}
			//boite_dialogue.showMessageDialog(null,infos_www(),"Infos Serveur Web",JOptionPane.INFORMATION_MESSAGE);
		}
		if(arg0.getSource() == bouton_bdd_appli){
			if(text_bdd_appli_name.getText()!=null && text_bdd_appli_nomcom.getText()!=null &&
			text_bdd_appli_lienweb.getText()!=null && text_bdd_appli_categorie.getText()!=null && 
			text_bdd_appli_description.getText()!=null && text_bdd_appli_developer.getText()!=null && 
			text_bdd_appli_version.getText()!=null){
				//ecriture bdd application
				new db().writeBDDappli(text_bdd_appli_name.getText(),text_bdd_appli_nomcom.getText(),text_bdd_appli_lienweb.getText(),text_bdd_appli_categorie.getText(),text_bdd_appli_description.getText(),text_bdd_appli_developer.getText(),text_bdd_appli_version.getText(),co);
				//creation dossier images slide
				new FileSystem(sudopass).createfolder("/var/www/images/slideshow/"+text_bdd_appli_nomcom.getText()+"");
				//copie icone application (et renomme le fichier)
				if(bouton_iconeappli.getText().equals(name_iconeappli)){
					String extensioniconeappli = name_iconeappli.substring(name_iconeappli.lastIndexOf("."));
					new FileSystem(sudopass).copyfile(path_iconeappli,"/var/www/images/"+text_bdd_appli_nomcom.getText()+""+extensioniconeappli);
				}
				//copie images slides et redimensionnement
				if(bouton_slideappli1.getText().equals(name_slideappli1)){
					new PicturesUtils().resizePicture(path_slideappli1,600, 400);
					new FileSystem(sudopass).copyfile(path_slideappli1,"/var/www/images/slideshow/"+text_bdd_appli_nomcom.getText()+"/"+name_slideappli1);
				}
				if(bouton_slideappli2.getText().equals(name_slideappli2)){
					new PicturesUtils().resizePicture(path_slideappli2,600, 400);
					new FileSystem(sudopass).copyfile(path_slideappli2,"/var/www/images/slideshow/"+text_bdd_appli_nomcom.getText()+"/"+name_slideappli2);
				}
				if(bouton_slideappli3.getText().equals(name_slideappli3)){
					new PicturesUtils().resizePicture(path_slideappli3,600, 400);
					new FileSystem(sudopass).copyfile(path_slideappli3,"/var/www/images/slideshow/"+text_bdd_appli_nomcom.getText()+"/"+name_slideappli3);
				}
				if(bouton_slideappli4.getText().equals(name_slideappli4)){
					new PicturesUtils().resizePicture(path_slideappli4,600, 400);
					new FileSystem(sudopass).copyfile(path_slideappli4,"/var/www/images/slideshow/"+text_bdd_appli_nomcom.getText()+"/"+name_slideappli4);
				}
				if(bouton_slideappli5.getText().equals(name_slideappli5)){
					new PicturesUtils().resizePicture(path_slideappli5,600, 400);
					new FileSystem(sudopass).copyfile(path_slideappli5,"/var/www/images/slideshow/"+text_bdd_appli_nomcom.getText()+"/"+name_slideappli5);
				}
				//insertion nom appli dans lshell.conf
				new FileSystem(sudopass).changeWord("'firefox',","'firefox','"+text_bdd_appli_nomcom.getText()+"',","/etc/lshell.conf");
				//boite de dialogue succes
				JOptionPane.showMessageDialog(null,"Importation des donnees pour l'application reussie","Succes Importation",JOptionPane.INFORMATION_MESSAGE);
			}//fin if remplissage formulaire
			else{
				System.out.println("Error !");
				JOptionPane.showMessageDialog(null,"Veuillez remplir tout les champs !","Erreur",JOptionPane.INFORMATION_MESSAGE);
			}
		}	
	}

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
